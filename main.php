<?php
    session_start();

    include "funciones.php";

    // Verificar si hay una sesión activa y obtener los datos del usuario
    $usuario = null;
    if (isset($_SESSION['id'])) {
        $usuario = obtener_usuario_por_id($_SESSION['id']);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> Granada Palace </title>

	<style>
        /*=============================================
        GLOBAL
        =============================================*/

        *{
            margin:0px;
            padding:0px;
            list-style: none;
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        .contenedor{
            position:relative;
            margin:auto;
            width:100%;
            height: auto;
        }

        .fila{
            position:relative;
            margin:auto;
            width:100%;
            height: auto;
            clear:both;
            display:table;
        }

        [class*="col-"]{
            float:left;
            padding:10px;
        }

        body {
            background-image: url("img/fondos/fondo_azul_suave2.jpg");
            background-size: cover;
            background-repeat:no-repeat;
            background-attachment: scroll;
        }

        /*=============================================
        SECCION 1
        =============================================*/

        header #logo{
            font-size:50px;
            text-align:center;
            line-height:60px;
            border-radius: 10px;
            transition: scale 0.3s ease;
        }

        header #logo:hover{
            scale: calc(1.05);
        }

        header #logo:active{
            scale: calc(0.9);
        }

        header #logo-largo {
            transition: scale 0.3s ease;
            float: right;
            border-radius: 10px;
        }

        header #logo-largo:hover{
            scale: calc(1.05);
        }

        header #logo-largo:active{
            scale: calc(0.9);
        }

        /*=============================================
        SECCION 2
        =============================================*/

        nav ul li{
            padding:10px;
            text-align:center;	
        }

        nav ul li a{
            display: block;
            background:#1A5276;
            font-family: Arial, Helvetica, sans-serif cursive;
            color:white;
            line-height:48px;
            border-radius: 5px;	
            transition: scale 0.3s ease;
        }

        nav ul li a:hover{
            background:#2980B9;
            scale: calc(1.1);
        }

        nav ul li a:active{
            background:#5499C7;
            scale: calc(0.9);
        }

        /*=============================================
        SECCION 3
        =============================================*/

        #seccion3 .col-lg-6 {
            padding:20px;
            display: flex;
            flex-direction: column; /* Mostrar los elementos en columnas  */ 
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            color: black;
        }

        #seccion3 a {
            transition: all 0.3s ease;
        }

        #seccion3 a:hover {
            opacity: 0.9;
        }

        #seccion3 img{	
            border-radius: 10%;
            width:200px;
            height:200px;
            padding:10px;
            transition: scale 0.3s ease;
        }

        #seccion3 img:hover{
            scale: calc(1.1);
        }

        #seccion3 img:active{
            scale: calc(0.9);
        }

        #seccion3 h2{
            font-family: Arial, Helvetica, sans-serif, cursive;
            font-size:40px;
            padding:10px;
        }

        #seccion3 p{
            padding:10px;
        }

        /* Estilos para la columna lateral secundaria */
        aside {
            background-color: #f3f3f3; /* Color de fondo */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra ligera */
        }

        aside h2 {
            color: #333; /* Color del título */
            font-size: 20px; /* Tamaño del título */
            margin-bottom: 15px; /* Espacio inferior */
        }

        aside p {
            color: #666; /* Color del texto */
            font-size: 16px; /* Tamaño del texto */
            margin-bottom: 10px; /* Espacio inferior */
        }

        aside button {
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

        aside button a {
            color: white; /* Color del enlace dentro del botón */
            text-decoration: none; /* Sin subrayado */
        }

        aside button:hover {
            background-color: #0056b3; /* Color de fondo al pasar el mouse */
            scale: 1.05;
        }



        /*=============================================
        SECCION 4
        =============================================*/

        footer{
            padding:20px 10px;
        }

        footer div{
            text-align:center;
            color:black;
            background:#85C1E9;
        }

        footer div p{
            color:black;
            text-align:left;
            font-size:13px;
        }

        footer #iconos{
            line-height:0px;
        }

        footer #iconos div{
            transition: scale 0.3s ease;
        }

        footer #iconos div:hover{
            scale: calc(1.2);
        }

        footer #iconos div:active{
            scale: calc(0.9);
        }

        #registro{
            line-height:55px;
        }

        footer #Informacion {
            line-height: 27.5px;
        }

        footer center a{
            text-align: center;
            border-radius:100%;	
            color:white;
        }

        #info {
            display: block;
            text-align: center;
            background-color: yellow;
        }

        /*=============================================
        PANTALLA DE ESCRITORIO GRANDE - LARGE (lg) - Tamaño portatil o pc
        =============================================*/

        @media(min-width:1200px){

            .col-lg-12{width:100%;}
            .col-lg-11{width:91.66666667%;}
            .col-lg-10{width:83.33333333%;}
            .col-lg-9{width:75%;}
            .col-lg-8{width:66.66666667%;}
            .col-lg-7{width:58.33333333%;}
            .col-lg-6{width:50%;}
            .col-lg-5{width:41.66666667%;}
            .col-lg-4{width: 33.33333333%;}
            .col-lg-3{width: 25%;}
            .col-lg-2 {width: 16.66666667%;}
            .col-lg-1 {width: 8.33333333%;}
            .col-lg-0 {display:none;}

            #seccion4 article p img{
                width:50%;
            }

            #caja1 {
                border-right:0.5px solid black;
                border-bottom:0.5px solid black;
            }

            #caja2 {
                border-bottom: 0.5px solid black;
            }
            #caja3{
                border-right:0.5px solid black;
                color: black;
            }
            
        }

        /*=============================================
        PANTALLA DE ESCRITORIO MEDIANO - MEDIUM (md) - Tamaño tablet horizontal 1024px
        =============================================*/

        @media(max-width:1199px) and (min-width:992px){

            .col-md-12{width:100%;}
            .col-md-11{width:91.66666667%;}
            .col-md-10{width:83.33333333%;}
            .col-md-9{width:75%;}
            .col-md-8{width:66.66666667%;}
            .col-md-7{width:58.33333333%;}
            .col-md-6{width:50%;}
            .col-md-5{width:41.66666667%;}
            .col-md-4{width: 33.33333333%;}
            .col-md-3{width: 25%;}
            .col-md-2{width: 16.66666667%;}
            .col-md-1{width: 8.33333333%;}
            .col-md-0 {display:none;}

            #seccion4 article p img{
                width:60%;
            }

            #caja1{
                border-right:0.5px solid black;
                border-bottom:0.5px solid black;
            }
            #caja2 {
                border-bottom: 0.5px solid black;
            }
            #caja3{
                border-right:0.5px solid black;
                color: black;
            }
            
        }

        /*=============================================
        PANTALLA DE TABLET - SMALL (sm) - Tamaño tablet vertical 768px
        =============================================*/

        @media(max-width:991px) and (min-width:768px){

            .col-sm-12{width:100%;}
            .col-sm-11{width:91.66666667%;}
            .col-sm-10{width:83.33333333%;}
            .col-sm-9{width:75%;}
            .col-sm-8{width:66.66666667%;}
            .col-sm-7{width:58.33333333%;}
            .col-sm-6{width:50%;}
            .col-sm-5{width:41.66666667%;}
            .col-sm-4{width: 33.33333333%;}
            .col-sm-3{width: 25%;}
            .col-sm-2{width: 16.66666667%;}
            .col-sm-1{width: 8.33333333%;}
            .col-sm-0 {display:none;}
            
            #seccion4 article p img{
                width:100%;
                margin-bottom: 20px;
            }
            #caja1{
                border-right:0.5px solid black;
                border-bottom:0.5px solid black;
            }
            #caja2 {
                border-bottom: 0.5px solid black;
            }
            #caja3{
                border-right:0.5px solid black;
                color: black;
            }
        }

        /*=============================================
        PANTALLA DE PHONES - EXTRA SMALL (xs) - Tamaño movil horizontal 480px o vertical 320px
        =============================================*/

        @media(max-width:767px){

            .col-xs-12{width:100%;}
            .col-xs-11{width:91.66666667%;}
            .col-xs-10{width:83.33333333%;}
            .col-xs-9{width:75%;}
            .col-xs-8{width:66.66666667%;}
            .col-xs-7{width:58.33333333%;}
            .col-xs-6{width:50%;}
            .col-xs-5{width:41.66666667%;}
            .col-xs-4{width: 33.33333333%;}
            .col-xs-3{width: 25%;}
            .col-xs-2{width: 16.66666667%;}
            .col-xs-1{width: 8.33333333%;}
            .col-xs-0 {display:none;}

            #seccion4 article p img{
                width:100%;
                margin-bottom: 20px;
            }
            #caja1 {
                border-bottom: 0.5px solid black;
            }
            #caja2 {
                border-bottom: 0.5px solid black;
            }
            #caja3 {
                border-bottom: 0.5px solid black;
            }
            #logo-largo {
                display: none; /* Oculta el elemento con el id 'logo-largo' en dispositivos móviles */
            }

        }
    </style>

</head>

<body>

	<div class="contenedor">

		<!--=============================================
		SECCION 1
		=============================================-->
		<header class="fila">
			<a href="presentacion.html">
			    <div id="logo" class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
				    <img id="logo" src="img/logos/logo-azul.png" width="120">
			    </div>
            </a>

			<div class="col-lg-6 col-md-7 col-sm-5 col-xs-0"></div>

            <a href="presentacion.html">
			    <div class="col-lg-5 col-md-4 col-sm-5 col-xs-12">
				    <img id="logo-largo" src="img/logos/logo-largo.png">
			    </div>
            </a>

		</header>

		<!--=============================================
		SECCION 2
		=============================================-->

		<nav class="fila">
			
			<ul>
				<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="habitaciones.php">Habitaciones</a></li>
				<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="servicios.html">Servicios</a></li>
				<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="presentacion.html">¿Quién somos?</a></li>
				<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="eventos.html">Eventos</a></li>
				<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="#">Contacto</a></li>
                <?php
                    if ($usuario) {
                        if ($usuario['tipo_usuario'] == "Cliente") {
                            echo '<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="datos_usuario.php">Mi usuario</a></li>';
                        } else if ($usuario['tipo_usuario'] == "Recepcionista") {
                            echo '<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="#">Gestión</a></li>';
                        } else {
                            echo '<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="#">Administración</a></li>';
                        }
                    } else {
                        echo '<li class="col-lg-2 col-md-2 col-sm-6 col-xs-12"><a id="boton" href="login.php">Login</a></li>';
                    }
                ?>
			</ul>

		</nav>
		<main>
			<!--=============================================
			SECCION 3
			=============================================-->
			<div id="seccion3" class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
				<a href="habitaciones.php">
					<div id="caja1" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<img src="img/habitaciones/habitacion_doble.jpg">
						<h2>Habitaciones</h2>
						<p>Disfrute de una amplia oferta</p>
					</div>
				</a>
				<a href="servicios.html">
					<div id="caja2" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<img src="img/servicios/servicio_habitaciones.jpg">
						<h2>Servicios</h2>
						<p>Relájese con vistas a la Alhambra</p>					
					</div>
				</a>
				<a href="eventos.html">
					<div id="caja3" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<img src="img/servicios/spa3.jpg">
						<h2>Eventos</h2>
						<p>Las últimas novedades</p>					
					</div>
				</a>
				<a href="presentacion.html">
					<div id="caja4" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<img src="img/servicios/piscina2.jpg">
						<h2>Conócenos</h2>
						<p>Eche un vistazo a nuestras instalaciones</p>
					</div>
				</a>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
				<!-- ZONA LATERAL SECUNDARIA -->
				<aside class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- Información secundaria aquí -->
					<h2>Información secundaria</h2>
					<p>Número total de habitaciones: <?php echo(numero_habitaciones());?></p>
					<p>Número de habitaciones libres: <?php echo(obtenerNumeroHabitacionesLibres());?></p>
					<p>Capacidad total del hotel: <?php echo(capacidad_total());?></p>
					<p>Número de huéspedes alojados: <?php echo(obtenerNumeroHuespedesAlojados());?></p>
                    <?php
                        if (!$usuario) {
                            echo '<a href="login.php"><button id="boton">Login</button></a>';
                            echo '<a href="formulario_registro.php"><button id="boton">Registro</button></a>';
                        } else {
                            echo '<a href="cerrar_sesion.php"><button id="boton">Cerrar sesion</button></a>';
                        }
                    ?>
				</aside>
			</div>
		</main>

		<!--=============================================
		SECCION 4
		=============================================-->

		<footer class="fila">

			<div id="Informacion" class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
				<p> C. Diego de Siloé, s/n, Granada <br> Teléfono: 958 30 12 22</p>
			</div>
			
			<div id="registro" class="col-lg-8 col-md-8 col-sm-6 col-xs-12">&copy; Todos los derechos reservados.</div>


			<div id="iconos" class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					
					<a href="https://www.instagram.com/granadapalace/"><img src="img/redes/instagram.png" width="35"></a>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					
					<a href="https://www.facebook.com/HotelGranadaPalace/?locale=es_ES"><img src="img/redes/facebook.png" width="32"></a>

				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					
					<a href="https://api.whatsapp.com/send?phone=NUMERO"><img src="img/redes/whatsapp.png" width="35"></a>

				</div>

			</div>
			
		</footer>

	</div>
    <div id="info">
        <p>José Antonio Carmona Molina - Ingeniería Informática + ADE</p>
        <p>Antonio Rodríguez Rodríguez - Ingeniería Informática + ADE</p>
        <a href="#">Documentacion</a>
        <br>
        <a href="#">Restauración de la BBDD</a>
    </div>
</body>
</html>