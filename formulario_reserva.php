<?php
    include 'funciones.php';

    // Inicializar un array para almacenar los mensajes de error
    $errors = array();
    $confirmMessage = "";

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['huespedes'])) {
            // Comprobar que se haya rellenado el número de huéspedes
            if (empty($_POST['huespedes'])) {
                $errors['huespedes'] = 'Por favor, ingrese el número de huéspedes.';
            }

            // Comprobar que la fecha de entrada sea posterior a la actual
            $fecha_entrada = $_POST['fecha_entrada'];
            if (strtotime($fecha_entrada) < strtotime(date('Y-m-d'))) {
                $errors['fecha_entrada'] = 'La fecha de entrada debe ser posterior a la actual.';
            }

            // Comprobar que la fecha de salida sea posterior a la de entrada
            $fecha_salida = $_POST['fecha_salida'];
            if (strtotime($fecha_salida) <= strtotime($fecha_entrada)) {
                $errors['fecha_salida'] = 'La fecha de salida debe ser posterior a la fecha de entrada.';
            }

            // Si no hay errores, buscar habitaciones disponibles
            if (empty($errors)) {
                $huespedes = $_POST['huespedes'];
                $preferencias = $_POST['preferencias'];

                // Buscar habitaciones disponibles
                $habitaciones = buscar_habitaciones_adecuadas($huespedes, $fecha_entrada, $fecha_salida);
            }
        } elseif (isset($_POST['confirmar_reserva'])) {
            // Lógica para confirmar la reserva
            $numero_habitacion = $_POST['numero_habitacion'];
            $confirmMessage = "Reserva confirmada para la habitación $numero_habitacion.";
        } elseif (isset($_POST['cancelar_reserva'])) {
            // Lógica para cancelar la reserva
            $confirmMessage = "Reserva cancelada.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Habitación</title>
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


        h2 {
            display: inline-block;
            background-color: #26C6DA;
            color: white;
            padding: 10px 20px;
            margin: 20px 0 -10px 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        #opciones {
            display: block;
            background-color: #0277BD;
            color: white;
            padding: 10px 20px;
            margin: 0px 0px 0px 0px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #26C6DA;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            transform: scale(1.1);
            background-color: #4169e1;
            transition-duration: 0.3s;
        }

        input[type="submit"]:active {
            transform: scale(0.9);
            background-color: blue; 
            transition-duration: 0.3s;
        }

        .principal {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border 0.3s ease-in-out;
        }

        .principal:hover {
            border-color: #add8e6;
        }

        .auxiliar {
            margin: 15px;
        }

        label {
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
        section {
            background-image: url("img/fondos/fondo_azul_suave.png");
            background-size: cover;
            background-repeat:no-repeat;
            background-attachment: scroll;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            max-width: 600px;
            transition: opacity 0.3s ease, scale 0.3s ease;
            color: black;
        }

        section:hover {
            opacity: 0.9;
            scale:calc(1.1);
        }

        section:hover #informacion_deluxe {
            font-size: 16px;
            opacity: 1;
            transition: font-size 0.3s ease, opacity 0.3s ease; /* Transiciones suaves */
            margin-top: 10px;
        }

        #informacion_deluxe {
            font-size: 0px;
            opacity: 0;
            transition: font-size 0.3s ease, opacity 0.3s ease, margin-top 0.3s ease; /* Transiciones suaves */
            text-align: left;
        }

        .confirm-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .confirm-form input[type="submit"] {
            width: 45%;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 100%; /* Hace que la imagen sea responsiva */
            height: auto; /* Mantiene la proporción de la imagen */
            border-radius: 10px;
            max-width: 250px;
        }
    </style>
</head>
<body>
    <h1>Reserva de Habitaciones</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2>Datos de la Habitación</h2>
        <div class="principal">
            <div class="intermedio">
                <div class="auxiliar">
                    <label for="fecha_entrada">Fecha de entrada:</label>
                    <input type="date" id="fecha_entrada" name="fecha_entrada" value="<?php echo isset($_POST['fecha_entrada']) ? htmlspecialchars($_POST['fecha_entrada']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['fecha_entrada'])): ?>
                        <span class="error-message"><?php echo $errors['fecha_entrada']; ?></span>
                    <?php endif; ?>                
                </div>
                <div class="auxiliar">
                    <label for="fecha_salida">Fecha de salida:</label>
                    <input type="date" id="fecha_salida" name="fecha_salida" value="<?php echo isset($_POST['fecha_salida']) ? htmlspecialchars($_POST['fecha_salida']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['fecha_salida'])): ?>
                        <span class="error-message"><?php echo $errors['fecha_salida']; ?></span>
                    <?php endif; ?>                
                </div>
            </div>
            <div class="intermedio">
                <div class="auxiliar">
                    <label for="huespedes">Número de huespedes:</label>
                    <input type="number" id="huespedes" name="huespedes" value="<?php echo isset($_POST['huespedes']) ? htmlspecialchars($_POST['huespedes']) : ''; ?>" placeholder="Introduzca el número de personas que se alojarán" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['huespedes'])): ?>
                        <span class="error-message"><?php echo $errors['huespedes']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="intermedio">
                <div class="auxiliar">
                    <label for="preferencias">Preferencias:</label>
                    <textarea id="preferencias" name="preferencias" placeholder="Indique si tiene alguna preferencia" <?php echo isset($disabled) ? $disabled : ''; ?>><?php echo isset($_POST['preferencias']) ? htmlspecialchars($_POST['preferencias']) : ''; ?></textarea>
                    <?php if(isset($errors['preferencias'])): ?>
                        <span class="error-message"><?php echo $errors['preferencias']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <input type="submit" value="Buscar reserva">
    </form>
    <?php
        if (!empty($habitaciones)) {
            echo '<h2 id="opciones">Mejores Opciones</h2>';
            // Loop a través de cada fila de resultados
            foreach($habitaciones as $habitacion) {
                // Generar el HTML para cada habitación
                echo '<section>';
                echo '<h2>' . htmlspecialchars($habitacion['numero_habitacion']) . '</h2>';
                echo '<p>' . htmlspecialchars($habitacion['descripcion']) . '</p>';
                // Obtener las imágenes de la habitación
                $imagenes = obtener_imagenes_habitacion($habitacion['id']);

                // Mostrar las imágenes
                foreach ($imagenes as $imagen) {
                    $image_data = base64_encode($imagen['foto']);
                    $image_type = 'jpeg'; // Asume el tipo de imagen. Se recomienda almacenar el tipo en la BD

                    echo '<img src="data:image/'.$image_type.';base64,'.$image_data.'" alt="Habitación">';
                }
                echo '<ul id="informacion_deluxe">';
                echo '<li><strong>Capacidad:</strong> ' . htmlspecialchars($habitacion['capacidad']) . '</li>';
                echo '<li><strong>Precio por noche:</strong> ' . htmlspecialchars($habitacion['precio_noche']) . '€</li>';
                echo '</ul>';
                echo '<form method="post" class="confirm-form">';
                echo '<input type="hidden" name="numero_habitacion" value="' . htmlspecialchars($habitacion['numero_habitacion']) . '">';
                echo '<input type="submit" name="confirmar_reserva" value="Confirmar">';
                echo '<input type="submit" name="cancelar_reserva" value="Cancelar">';
                echo '</form>';
                echo '</section>';
            }
        }

        if (!empty($confirmMessage)) {
            echo '<p>' . htmlspecialchars($confirmMessage) . '</p>';
        }
    ?>
</body>
</html>
