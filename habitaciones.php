<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones Palace</title>
    <link rel="icon" href="img/logos/logo.png">
    <style>
        body {
            background-image: url("img/fondos/fondo2.png");
            background-size: cover;
            background-repeat:no-repeat;
            background-attachment: scroll;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .contenedor{
            position:relative;
            margin:auto;
            width:100%;
            height: auto;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            z-index: 1000;
        }
        #logo-largo {
            max-width: 20%;
        }
        main {
            margin-top: 180px;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
        }
        a {
            text-decoration: none;
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

        h2 {
            color: #007bff;
            margin-bottom: 10px;
        }

        p {
            line-height: 1.6;
        }

        ul {
            padding-left: 20px;
        }

        img {
            display: block;
            margin: 20px auto;
            max-width: 100%; /* Hace que la imagen sea responsiva */
            height: auto; /* Mantiene la proporción de la imagen */
            border-radius: 10px;
            max-width: 250px;
        }

        /* Estilo específico para la imagen del wifi */
        #wifi {
            max-width: 150px;
        }

        .fila{
            position:relative;
            margin:auto;
            width:100%;
            height: auto;
            clear:both;
            display:table;
        }

        footer {
            padding: 20px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #85C1E9;
            color: black;
        }

        footer div {
            text-align: center;
            margin-left: 20px;
        }

        footer div p {
            font-size: 13px;
            margin: 0;
        }

        footer #iconos {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer #iconos div{
            transition: scale 0.3s ease;
        }

        footer #iconos div:hover{
            scale: calc(1.2);
        }

        #registro {
            flex-grow: 1;
            text-align: right;
            padding-right: 20px; /* Ajusta el espacio entre los elementos */
        }

        button {
            display: block; /* Hace que los botones sean bloques */
            width: 100%; /* Ancho completo */
            padding: 10px 0; /* Relleno */
            margin-top: 15px; /* Espacio superior */
            background-color: #007bff; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño del texto */
            cursor: pointer; /* Cursor al pasar sobre el botón */
            transition: all 0.3s ease; /* Transición suave del color de fondo */
        }

        button a {
            color: white; 
            text-decoration: none; 
        }

        button:hover {
            background-color: #0056b3; 
            scale: 1.05;
        }

    </style>
</head>
<body>
    <div class="contenedor">
        <header>
            <a href="presentacion.html"><img id="logo-largo" src="./img/logos/logo-largo.png" alt="Logo Hotel Palace"></a>
        </header>
        <main>
            <?php                
                include 'funciones.php'; 

                // Verificar si hay una sesión activa y obtener los datos del usuario
                $usuario = null;
                if (isset($_SESSION['id'])) {
                    $usuario = obtener_usuario_por_id($_SESSION['id']);
                }

                if($usuario) {
                    if ($usuario['tipo_usuario'] == "Cliente" || $usuario['tipo_usuario'] == "Recepcionista") {
                        echo '<button id="boton"><a href="formulario_reserva.php">Acceder Formulario Reserva</a></button>';
                    }
                }

                $habitaciones = obtener_habitaciones();

                // Verificar si hay resultados
                if (!empty($habitaciones)) {
                    echo '<h1>Habitaciones del Hotel Palace</h1>';
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
                        echo '</section>';
                    }
                }

                // Cerrar la conexión
                $conn->close();
                ?>

        </main>
        <footer class="fila">
            <div id="Informacion">
                <p> C. Diego de Siloé, s/n, Granada <br> Teléfono: 958 30 12 22</p>
            </div>
            <div id="iconos">
                <div>
                    <a href="https://www.instagram.com/granadapalace/"><img src="img/redes/instagram.png" width="35"></a>
                </div>
                <div>
                    <a href="https://www.facebook.com/HotelGranadaPalace/?locale=es_ES"><img src="img/redes/facebook.png" width="32"></a>
                </div>
                <div>
                    <a href="https://api.whatsapp.com/send?phone=NUMERO"><img src="img/redes/whatsapp.png" width="35"></a> <!-- Falta cambiar NUMERO -->
                </div>
            </div>
        </footer>
    </div>
</body>
</html>