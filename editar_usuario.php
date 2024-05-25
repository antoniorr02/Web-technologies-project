<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edición de usuario</title>
    <style>
        body {
            border: 1px solid black;
            padding: 5px;
        }
        h1 {
            background-color: #0277BD;
            color: white;
            padding: 5px;
            margin-bottom: 0px;
        }
        h2 {
            display: inline-block;
            border: 1px solid black;
            padding: 5px;
            background-color: #26C6DA;
            margin-bottom: -10px;
            margin-left: 30px;
        }
        input[type="submit"] {
            display: inline-block;
            border: 1px solid black;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            background-color: #26C6DA;
            margin-left: calc(50% - 10px);
        }
        .principal {
            background-color: #B2EBF2;
            padding: 20px;
            border: 1px solid black;
            transition: border 0.3s ease-in-out; 
        }
        .principal:hover {
            border: 10px solid #009688; /* Cambia el borde al pasar el ratón sobre el bloque */
        }
        .principal:hover .informacion {
            font-size: 16px;
            opacity: 1;
        }
        .informacion {
            font-size: 0px;
            opacity: 0; 
            transition: opacity 0.3s ease-in-out; 
        }
        #preferencias {
            margin: 10px;
        }
        .intermedio {
            background-color: #80DEEA;
            padding: 10px;
        }
        .auxiliar {
            display: inline-block;
            padding: 5px;
            width: calc(50% - 20px);
        }
        #aux1, #aux3, #aux10 {
            border-right: 5px solid #26C6DA;
        }
        #aux10 label div, #aux11 label div{
            display: block;
        }
        #intermedio2 {
            margin-top: 10px;
        }
        #intermedio4 {
            margin-top: 10px;
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

        $id = "";
        if(isset($_GET['usuario_id'])) {
            $id = $_GET['usuario_id'];
        }
        $fumadores = false;
        $mascotas = false;
        $vistas = false;
        $moqueta = false;
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

            // Validar el nombre
            if (empty($_POST["nombre"])) {
                $errors["nombre"] = "El nombre es obligatorio.";
            } else {
                $nombre = $_POST['nombre'];
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

            // Validar el idioma
            if (empty($_POST["idioma"])) {
                $errors["idioma"] = "El idioma es obligatorio.";
            }

            // Validar las preferencias de habitación
            if (isset($_POST['fumadores'])) {
                $fumadores = true;
            }
            if (isset($_POST['mascotas'])) {
                $mascotas = true;
            }
            if (isset($_POST['vistas'])) {
                $vistas = true;
            }
            if (isset($_POST['moqueta'])) {
                $moqueta = true;
            }

            if (empty($errors)){
                echo "<h1 id='exito'>Los datos se han recibido correctamente</h1>";
                $disabled = "disabled";

                $id = $_POST['usuario_id'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $dni = $_POST['dni'];
                $nacionalidad = $_POST['nacionalidad'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $sexo = $_POST['sexo'];
                $correo = $_POST['correo'];
                $clave = $_POST['clave'];
                $idioma_seleccionado = $_POST['idioma'];
                $datos = $_POST['datos'];
                
                // Insertar usuario
                modificar_usuario($id, $nombre, $apellidos, $dni, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $clave, $idioma_seleccionado, $fumadores, $mascotas, $vistas, $moqueta, $datos);
                echo '<p>Los datos se han recibido correctamente. <a href="main.php">Ir a la página principal</a></p>';
            }
        } else {        
            // Obtener los datos del usuario por su ID
            $usuario_a_modificar = obtener_usuario_por_id($id);
            
            // Verificar si se encontró un usuario con el ID dado
            if($usuario_a_modificar) {
                // Llenar los campos del formulario con los datos del usuario
                $nombre = $usuario_a_modificar['nombre'];
                $apellidos = $usuario_a_modificar['apellidos'];
                $dni = $usuario_a_modificar['dni'];
                $nacionalidad = $usuario_a_modificar['nacionalidad'];
                $fecha_nacimiento = $usuario_a_modificar['fecha_nacimiento'];
                $sexo = $usuario_a_modificar['sexo'];
                $correo = $usuario_a_modificar['correo'];
                $idioma_seleccionado = $usuario_a_modificar['idioma'];
                $fumadores = isset($usuario_a_modificar['fumador']) ? $usuario_a_modificar['fumador'] : false;
                $mascotas = isset($usuario_a_modificar['mascotas']) ? $usuario_a_modificar['mascotas'] : false;
                $vistas = isset($usuario_a_modificar['vistas']) ? $usuario_a_modificar['vistas'] : false;
                $moqueta = isset($usuario_a_modificar['moqueta']) ? $usuario_a_modificar['moqueta'] : false;
                $datos = $usuario_a_modificar['datos'];
            }
        }
    ?>
    <h1>Edición de usuario</h1>
    <?php if(!empty($_POST['nombre'])): ?>
        <?php echo"<p>Bienvenido/a $nombre, siga instrucciones a continuación:</p>"?>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($id); ?>">
        <h2>Datos personales</h2>
        <div class="principal" id="principal1">
            <div class="intermedio" id="intermedio1">
                <div class="auxiliar" id="aux1">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>" placeholder="Escribe tu nombre" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['nombre'])): ?>
                        <span class="error-message"><?php echo $errors['nombre']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux2">
                    <label for="foto">Fotografía:</label>
                    <input type="file" id="foto" name="foto" placeholder="Sube tu foto" value="<?php echo isset($_POST['foto']) ? htmlspecialchars($_POST['foto']) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                </div>
                <div class="auxiliar" id="aux3">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : ''; ?>" placeholder="Escribe tu apellidos" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['apellidos'])): ?>
                        <span class="error-message"><?php echo $errors['apellidos']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="intermedio" id="intermedio2">
                <div class="auxiliar" id="aux4">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo isset($dni) ? htmlspecialchars($dni) : ''; ?>" placeholder="Escribe tu dni" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['dni'])): ?>
                        <span class="error-message"><?php echo $errors['dni']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="auxiliar" id="aux5">
                    <label for="nacionalidad">Nacionalidad:</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" value="<?php echo isset($nacionalidad) ? htmlspecialchars($nacionalidad) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                </div>
                <div class="auxiliar" id="aux6">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($fecha_nacimiento) ? htmlspecialchars($fecha_nacimiento) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                    <?php if(isset($errors['fecha_nacimiento'])): ?>
                        <span class="error-message"><?php echo $errors['fecha_nacimiento']; ?></span>
                    <?php endif; ?>
                </div>
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
                <input type="email" id="correo" name="correo" placeholder="Escriba su correo" value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" <?php echo isset($disabled) ? $disabled : ''; ?>>
                <?php if(isset($errors['correo'])): ?>
                    <span class="error-message"><?php echo $errors['correo']; ?></span>
                <?php endif; ?>
            </div>
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
                </div>
            </div>
            <div class="informacion" id="informacion2">
                <p>Podrá acceder con estos datos en cualquier momento. Asegúrese de recordar sus credenciales.</p>
            </div>
        </div>

        <h2>Preferencias</h2>
        <div class="principal" id="principal3">
            <div class="auxiliar" id="aux10">
                <div><label>Idioma preferido:</label></div>
                <?php if(isset($errors['idioma'])): ?>
                    <span class="error-message"><?php echo $errors['idioma']; ?></span>
                <?php endif; ?>
                <div>
                    <label for="espanol">Español</label>
                    <input type="radio" id="espanol" name="idioma" value="espanol" <?php echo ($idioma_seleccionado === 'espanol') ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                </div>
                <div>
                    <label for="ingles">Inglés</label>
                    <input type="radio" id="ingles" name="idioma" value="ingles" <?php echo ($idioma_seleccionado === 'ingles') ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                </div>
                <div>
                    <label for="frances">Francés</label>
                    <input type="radio" id="frances" name="idioma" value="frances" <?php echo ($idioma_seleccionado === 'frances') ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>

                </div>
            </div>
            <div class="auxiliar" id="aux11">
                <div><label>Preferencias de habitación:</label></div>
                
                <input type="checkbox" id="fumadores" name="fumadores" <?php echo $fumadores ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                <label for="fumadores">Para fumadores</label><br>
                    
                <input type="checkbox" id="mascotas" name="mascotas" <?php echo $mascotas ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                <label for="mascotas">Que permitan mascotas</label><br>
                
                <input type="checkbox" id="vistas" name="vistas" <?php echo $vistas ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                <label for="vistas">Con vistas</label><br>
                
                <input type="checkbox" id="moqueta" name="moqueta" <?php echo $moqueta ? 'checked' : ''; ?> <?php echo isset($disabled) ? $disabled : ''; ?>>
                <label for="moqueta">Con moqueta</label><br>
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
