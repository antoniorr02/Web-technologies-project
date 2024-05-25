<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
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
<?php
        include 'funciones.php';

        // Verificar si se ha enviado el formulario para borrar un usuario
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['usuario_id'])) {
            // Obtener el ID del usuario a borrar desde el formulario
            $usuario_id = $_POST['usuario_id'];

            // Llamar a la función para borrar el usuario
            borrar_usuario($usuario_id);
        }

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
            // Inicializar un array para almacenar los mensajes de error
            $errors = array();

            // Validar el nombre
            if (empty($_POST["nombre"])) {
                $errors["nombre"] = "El nombre es obligatorio.";
            } else {
                $nombre = $_POST['nombre'];
            }

            // Validar los apellidos
            if (empty($_POST["apellidos"])) {
                $errors["apellidos"] = "Los apellidos son obligatorio.";
            } else {
                $apellidos = $_POST['apellidos'];
            }

            // Validar el DNI
            if (empty($_POST["dni"])) {
                $errors["dni"] = "El DNI es obligatorio.";
            } else {
                // Verificar si el DNI tiene el formato correcto (8 dígitos seguidos de una letra)
                if (!preg_match("/^[0-9]{8}[a-zA-Z]$/", $_POST["dni"])) {
                    $errors["dni"] = "El formato del DNI no es válido.";
                } else {
                    $numero = substr($_POST['dni'], 0, 8); // Los primeros 8 caracteres son el número
                    $letra = strtoupper(substr($_POST['dni'], -1)); // El último carácter es la letra
                    $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
                    $letra_correcta = $letras[$numero % 23];
                    if ($letra != $letra_correcta) {
                        $errors["dni"] = "El DNI no es válido.";
                    }
                }
            }

            // Validar la fecha de nacimiento y la edad
            if (empty($_POST["fecha_nacimiento"])) {
                $errors["fecha_nacimiento"] = "La fecha de nacimiento es obligatoria.";
            } else {
                $fecha_nacimiento = new DateTime($_POST["fecha_nacimiento"]);
                $hoy = new DateTime();
                $edad = $hoy->diff($fecha_nacimiento)->y;
                if ($edad < 18) {
                    $errors["fecha_nacimiento"] = "La persona debe ser mayor de edad.";
                }
            }

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

                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $tarjeta = $_POST["tarjeta"];
                $dni = $_POST['dni'];
                $nacionalidad = $_POST['nacionalidad'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $sexo = $_POST['sexo'];
                $correo = $_POST['correo'];
                $clave = $_POST['clave'];
                $datos = $_POST['datos'];
                $tipo_usuario = "cliente";

                // Insertar usuario
                insertar_usuario($nombre, $apellidos, $tarjeta, $dni, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $clave, $datos, $tipo_usuario);
            }
        }
    ?>
    <h1>Registro de usuarios</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h2>Datos personales</h2>
        <div class="principal" id="principal1">
            <div class="intermedio" id="intermedio1">
                <div class="auxiliar" id="aux1">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" placeholder="Introduzca su nombre" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['nombre'])): ?>
                        <span class="error-message"><?php echo $errors['nombre']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux2">
                    <label for="tarjeta">Tarjeta:</label>
                    <input type="text" id="tarjeta" name="tarjeta" value="<?php echo isset($_POST['tarjeta']) ? htmlspecialchars($_POST['tarjeta']) : ''; ?>" placeholder="Introduzca su tarjeta" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['tarjeta'])): ?>
                        <span class="error-message"><?php echo $errors['tarjeta']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux3">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>" placeholder="Introduzca sus apellidos" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['apellidos'])): ?>
                        <span class="error-message"><?php echo $errors['apellidos']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="intermedio" id="intermedio2">
                <div class="auxiliar" id="aux4">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo isset($_POST['dni']) ? htmlspecialchars($_POST['dni']) : ''; ?>" placeholder="Escribe tu dni" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['dni'])): ?>
                        <span class="error-message"><?php echo $errors['dni']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux5">
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" value="España" <?php echo isset($disabled) ? $disabled : ''; ?>>
                </div>
                <div class="auxiliar" id="aux6">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['fecha_nacimiento'])): ?>
                        <span class="error-message"><?php echo $errors['fecha_nacimiento']; ?></span>
                    <?php endif; ?>                </div>
                <div class="auxiliar" id="aux7">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo" <?php echo isset($disabled) ? $disabled : ''; ?>>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">No deseo indicarlo</option>
                    </select>
                </div>
            </div>
            <div class="informacion" id="informacion1">
                <p>En cumplimiento del Real Decreto 933/2021, del 26 de Octubre, sus datos serán comunicados a la Dirección General de la Policía.</p>
            </div>
        </div>

        <h2>Datos de acceso</h2>
        <div class="principal" id="principal2">
            <div class="intermedio" id="intermedio3">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" placeholder="Escriba su correo" value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
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
            </div>
            <div class="informacion" id="informacion2">
                <p>Podrá acceder con estos datos en cualquier momento. Asegúrese de recordar sus credenciales.</p>
            </div>
        </div>
        <div id="preferencias">
            <label for="datos">Tratamiento de datos:</label>
            <select id="datos" name="datos">
                <option value="total">Acepta el almacenamiento de mis datos y el envío a terceros</option>
                <option value="parcial">Acepta el almacenamiento de mis datos pero no el envío a terceros</option>
                <option value="ninguno">No acepta el almacenamiento de mis datos ni el envío a terceros</option>
            </select>
        </div>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>