<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edición de Habitaciones</title>
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
            border-color: #add8e6; /* LightBlue */
        }

        label {
            font-weight: bold;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
        include 'funciones.php';

        $habitacion_id = 1; // ESTE ID SE DEBE MODIFICAR POR UN GET DE LA PÁGINA QUE SE LE PINCHA A LA HABITACIÓN QUE SE QUIERE MODIFICAR

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_habitacion'])) {
            // Inicializar un array para almacenar los mensajes de error
            $errors = array();

            // Validar el número de habitación
            if (empty($_POST["numero_habitacion"])) {
                $errors["numero_habitacion"] = "El número de habitación es obligatorio.";
            } else {
                // Aquí podrías incluir una verificación para asegurarte de que no haya dos habitaciones con el mismo número
                $numero_habitacion = $_POST['numero_habitacion'];
            }

            // Validar la capacidad
            if (empty($_POST["capacidad"]) || !is_numeric($_POST["capacidad"])) {
                $errors["capacidad"] = "La capacidad debe ser un número.";
            } else {
                $capacidad = $_POST['capacidad'];
            }

            // Validar el precio por noche
            if (empty($_POST["precio_noche"]) || !is_numeric($_POST["precio_noche"])) {
                $errors["precio_noche"] = "El precio por noche debe ser un número.";
            } else {
                $precio_noche = $_POST['precio_noche'];
            }

            // Validar la descripción
            if (empty($_POST["descripcion"])) {
                $errors["descripcion"] = "La descripción es obligatoria.";
            } else {
                $descripcion = $_POST['descripcion'];
            }

            // Validar las fotografías (si lo deseas, puedes implementar la lógica para subir imágenes aquí)

            if (empty($errors)){
                echo "<h1 id='exito'>La habitación se ha modificado correctamente</h1>";
                $disabled = "disabled";

                $numero_habitacion = $_POST['numero_habitacion'];
                $capacidad = $_POST['capacidad'];
                $precio_noche = $_POST['precio_noche'];
                $descripcion = $_POST['descripcion'];
                
                // Insertar habitación
                modificar_habitacion($habitacion_id, $numero_habitacion, $capacidad, $precio_noche, $descripcion);
            }
        } else {        
            // Obtener los datos de la habitación por su ID
            $habitacion_a_modificar = obtener_habitacion_por_id($habitacion_id);
            
            if($habitacion_a_modificar) {
                // Llenar los campos del formulario con los datos de la habitación
                $numero_habitacion = $habitacion_a_modificar['numero_habitacion'];
                $capacidad = $habitacion_a_modificar['capacidad'];
                $precio_noche = $habitacion_a_modificar['precio_noche'];
                $descripcion = $habitacion_a_modificar['descripcion'];
            }
        }
    ?>
    <h1>Editar habitación</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2>Datos de la Habitación</h2>
        <div class="principal">
            <div class="intermedio">
                <div class="auxiliar">
                    <label for="numero_habitacion">Número de Habitación:</label>
                    <input type="text" id="numero_habitacion" name="numero_habitacion" value="<?php echo isset($numero_habitacion) ? htmlspecialchars($numero_habitacion) : ''; ?>" placeholder="Introduzca el número o nombre de la habitación" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['numero_habitacion'])): ?>
                        <span class="error-message"><?php echo $errors['numero_habitacion']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar">
                    <label for="capacidad">Capacidad:</label>
                    <input type="number" id="capacidad" name="capacidad" value="<?php echo isset($capacidad) ? htmlspecialchars($capacidad) : ''; ?>" placeholder="Introduzca la capacidad máxima de la habitación" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['capacidad'])): ?>
                        <span class="error-message"><?php echo $errors['capacidad']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar">
                    <label for="precio_noche">Precio por Noche:</label>
                    <input type="number" id="precio_noche" name="precio_noche" value="<?php echo isset($precio_noche) ? htmlspecialchars($precio_noche) : ''; ?>" placeholder="Introduzca el precio por noche de la habitación" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['precio_noche'])): ?>
                        <span class="error-message"><?php echo $errors['precio_noche']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="intermedio">
                <div class="auxiliar">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Escriba una descripción de la habitación" <?php echo isset($disabled) ? $disabled : ''; ?>><?php echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; ?></textarea>
                    <?php if(isset($errors['descripcion'])): ?>
                        <span class="error-message"><?php echo $errors['descripcion']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <input type="submit" value="Registrar Cambios">
    </form>
</body>
</html>
