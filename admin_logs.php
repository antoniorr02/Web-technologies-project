<?php
// Iniciar sesión y verificar si el usuario es administrador
session_start();
include "conexion.php";

$sql = "SELECT * FROM logs ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Logs de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>Logs de Eventos</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Descripción</th>
                    <th>ID de Usuario</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($log = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                    <td><?php echo htmlspecialchars($log['descripcion']); ?></td>
                    <?php if(isset($log['user_id'])): ?>
                        <td><?php echo htmlspecialchars($log['user_id']); ?></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
