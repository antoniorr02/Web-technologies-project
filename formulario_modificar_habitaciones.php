<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Imágenes de Habitación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            background-color: #0277BD;
            color: white;
            padding: 10px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        img {
            max-width: 200px;
            margin-bottom: 10px;
        }

        .eliminar-foto {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php
include 'funciones.php';

function is_image($file) {
    $datos = getimagesize($file);
    return $datos ? ((in_array($datos[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_BMP, IMAGETYPE_PNG, IMAGETYPE_BMP))) ? true : false) : false;
}

// Procesar la subida de imágenes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['habitacion_id'])) {
    $habitacion_id = $_POST['habitacion_id'];
    $imagenes = $_FILES['imagenes'];

    foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
        // Verificar si se subió correctamente
        if (is_uploaded_file($tmp_name)) {
            if (is_image($tmp_name)) {
                // Leer el contenido del archivo
                $imagen_blob = file_get_contents($tmp_name);
                
                // Preparar la consulta SQL para insertar la imagen en la base de datos
                $stmt = $conn->prepare("INSERT INTO fotos_habitacion (habitacion_id, foto) VALUES (?, ?)");
                
                // Vincular el parámetro y ejecutar la consulta
                $null = NULL; // Necesario para pasar un BLOB
                $stmt->bind_param("ib", $habitacion_id, $null);
                $stmt->send_long_data(1, $imagen_blob);
                $stmt->execute();
            }
        }
    }

    // Redireccionar o mostrar un mensaje de éxito
}

// Verificar si se ha enviado el formulario para borrar una foto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Obtener el ID del usuario a borrar desde el formulario
    $foto_borrar = $_POST['id'];
    
    // Llamar a la función para borrar la foto
    eliminar_foto($foto_borrar);
}

$habitacion_id = 1; // ESTE ID SE DEBE MODIFICAR POR UN GET DE LA PÁGINA QUE SE LE PINCHA A LA HABITACIÓN QUE SE QUIERE MODIFICAR

?>

<h2>Añadir nuevas imágenes:</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <input type="file" name="imagenes[]" multiple>
    <input type="hidden" name="habitacion_id" value="<?php echo $habitacion_id; ?>">
    <input type="submit" value="Subir Imágenes">
</form>

<?php
// Obtener las imágenes existentes de la base de datos
$imagenes_habitacion = obtener_imagenes_habitacion($habitacion_id);

if (!empty($imagenes_habitacion)) {
    echo "<h2>Imágenes existentes:</h2>";
    foreach ($imagenes_habitacion as $imagen) {
        if (isset($imagen['foto']) && !empty($imagen['foto'])) {
            $image_data = base64_encode($imagen['foto']);

            echo "<div>";
            echo '<img src="data:image/;base64,'.$image_data.'">';
            echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "' style='margin-bottom: 10px; display: flex; justify-content: center;'>";
            echo "<input type='hidden' name='id' value='" . $imagen['id'] . "'>";
            echo "<input type='submit' value='Borrar'>";
            echo "</form>";
            echo "</div>";
        }
    }
}
?>

</body>
</html>
