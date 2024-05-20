<?php
    include 'funciones.php';

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['huespedes'])) {
        // Inicializar un array para almacenar los mensajes de error
        $errors = array();

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

        if (empty($errors)){
            $disabled = "disabled";

            $huespedes = $_POST['huespedes'];
            $fecha_entrada = $_POST['fecha_entrada'];
            $fecha_salida = $_POST['fecha_salida'];
            $preferencias = $_POST['preferencias'];

            // Falta hacer esta función en funciones.php para filtrar las habitaciones
            $habitaciones = buscar_habitaciones_adecuadas($huespedes, $fecha_entrada, $fecha_salida);
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
        <input type="submit" value="Realizar reserva">
    </form>
    <?php if (!empty($habitaciones)): ?>
        <h2>Seleccione la habitación que desee</h2>
        <ul>
            <!--Seguramente tengamos que buscar un formato a esto y unificar para cada vez que se muestre el listado de habitaciones-->
            <!--Además cuando se pulse debe de comenzar la cuenta atrás de 30 segundos para que el usuario confirme (estado: Pendiente)-->
            <!--Además al pulsar sobre la habitación saldrá dos botones en la interfaz el de confirmar reserva o cancelarla-->
            <?php foreach ($habitaciones as $habitacion): ?>
                <li><?php echo htmlspecialchars($habitacion['numero_habitacion']); ?> - Capacidad: <?php echo htmlspecialchars($habitacion['capacidad']); ?> - Precio por noche: <?php echo htmlspecialchars($habitacion['precio_noche']); ?>€</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>