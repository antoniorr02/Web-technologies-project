<?php
session_start();
include 'funciones.php';

$user_id = $_SESSION['id'];

$usuario = obtener_usuario_por_id($user_id);
$reservas_activas = obtener_reservas_activas($user_id);
$historial_reservas = obtener_historial_reservas($user_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .info {
            margin-bottom: 20px;
        }
        .info label {
            font-weight: bold;
        }
        .reservas {
            margin-top: 20px;
        }
        .reservas table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #ddd;
        }
        .reservas th, .reservas td {
            padding: 8px;
            text-align: left;
        }
        .reservas th {
            background-color: #f2f2f2;
        }
        .btn-editar {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .btn-editar:hover {
            transform: scale(1.1);
            background-color: #0056b3;
            border-radius: 10px;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Perfil del Cliente</h1>
        <div class="info">
            <label for="nombre">Nombre:</label>
            <span id="nombre"><?php echo htmlspecialchars($usuario['nombre']); ?></span>
            <br>
            <label for="apellido">Apellido:</label>
            <span id="apellido"><?php echo htmlspecialchars($usuario['apellidos']); ?></span>
            <br>
            <label for="dni">DNI:</label>
            <span id="dni"><?php echo htmlspecialchars($usuario['dni']); ?></span>
            <br>
            <label for="email">Email:</label>
            <span id="email"><?php echo htmlspecialchars($usuario['correo']); ?></span>
            <br>
            <label for="tarjeta">Tarjeta de Crédito:</label>
            <span id="tarjeta"><?php echo '**** **** **** ' . substr($usuario['tarjeta_credito'], -4); ?></span>
        </div>
        <a href="editar_usuario.php"><button class="btn-editar">Editar Datos</button></a>
        <div class="reservas">
            <h2>Reservas Activas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Salida</th>
                        <th>Habitación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas_activas as $reserva) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['fecha_entrada']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_salida']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['id_habitacion']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="reservas">
            <h2>Historial de Reservas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Salida</th>
                        <th>Habitación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial_reservas as $reserva) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reserva['fecha_entrada']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['fecha_salida']); ?></td>
                        <td><?php echo htmlspecialchars($reserva['id_habitacion']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
