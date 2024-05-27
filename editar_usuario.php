<?php
    session_start();
    $user_id = $_SESSION['id'];

    include 'funciones.php';

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tarjeta'])) {
        // Inicializar un array para almacenar los mensajes de error
        $errors = array();

        // Validar el email
        if (empty($_POST["correo"])) {
            $errors["correo"] = "El correo es obligatorio.";
        } elseif (!filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL)) {
            $errors["correo"] = "El correo no es válido.";
        }

        // Validar la clave
        if (empty($_POST["clave"]) || empty($_POST["clave_repetida"])) {
            $errors["clave"] = "La clave es obligatoria.";
        } elseif (strlen($_POST["clave"]) < 5) {
            $errors["clave"] = "Clave demasiado corta.";
        } elseif ($_POST["clave"] !== $_POST["clave_repetida"]) {
            $errors["clave"] = "Las claves no coinciden.";
        }

        // Validar la tarjeta
        if (empty($_POST["tarjeta"])) {
            $errors["tarjeta"] = "El número de tarjeta es obligatorio.";
        } elseif (!luhn($_POST["tarjeta"])) {
            $errors["tarjeta"] = "El número de tarjeta no es válido";
        }

        if (empty($errors)){
            echo "<h1 id='exito'>Los datos se han recibido correctamente</h1>";
            $disabled = "disabled";

            $tarjeta = $_POST["tarjeta"];
            $correo = $_POST['correo'];
            $clave = $_POST['clave'];

            // editar usuario
            modificar_usuario($user_id, $tarjeta, $correo, $clave);
        }
    } else {        
        // Obtener los datos del usuario por su ID
        $usuario_a_modificar = obtener_usuario_por_id($user_id);
        
        if($usuario_a_modificar) {
            $tarjeta = $usuario_a_modificar["tarjeta_credito"];
            $correo = $usuario_a_modificar['correo'];
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edicción de usuario</title>
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
        input[type="email"],
        input[type="date"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 5px;
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

        .principal:hover .informacion {
            font-size: 16px;
            opacity: 1;
            transition: font-size 0.3s ease, opacity 0.3s ease; /* Transiciones suaves */
        }

        .informacion {
            font-size: 0px;
            opacity: 0;
            transition: font-size 0.3s ease, opacity 0.3s ease; /* Transiciones suaves */
        }

        .auxiliar {
            display: inline-block;
            width: calc(50% - 20px);
            margin-bottom: 10px;
        }

        #preferencias {
            margin: 10px 0;
        }

        label {
            font-weight: bold;
        }
        #exito {
            background-color: #000080;
            color: #26C6DA;
            padding: 5px;
            text-align: center;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Modificar datos personales</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2>Editar</h2>
        <div class="principal" id="principal2">
            <div class="intermedio" id="intermedio3">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" placeholder="Escriba su correo" value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                <?php if(isset($errors['correo'])): ?>
                    <span class="error-message"><?php echo $errors['correo']; ?></span>
                <?php endif; ?>            </div>
            <div class="intermedio" id="intermedio4">
                <div class="auxiliar" id="aux8">
                    <label for="clave">Clave:</label>
                    <input type="password" id="clave" name="clave" placeholder="Escriba la contraseña" value="<?php echo isset($_POST['clave']) ? htmlspecialchars($_POST['clave']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['clave'])): ?>
                        <span class="error-message"><?php echo $errors['clave']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux9">
                    <label for="clave_repetida">Repetir clave:</label>
                    <input type="password" id="clave_repetida" name="clave_repetida" placeholder="Repita la contraseña" value="<?php echo isset($_POST['clave']) ? htmlspecialchars($_POST['clave']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['clave'])): ?>
                        <span class="error-message"><?php echo $errors['clave']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux2">
                    <label for="tarjeta">Tarjeta:</label>
                    <input type="text" id="tarjeta" name="tarjeta" value="<?php echo isset($tarjeta) ? htmlspecialchars($tarjeta) : ''; ?>" placeholder="Introduzca su tarjeta" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['tarjeta'])): ?>
                        <span class="error-message"><?php echo $errors['tarjeta']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="informacion" id="informacion2">
                <p>Está modificando sus datos...</p>
            </div>
        </div>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>