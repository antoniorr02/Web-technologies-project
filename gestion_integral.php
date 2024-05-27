<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión Integral de Habitaciones</title>
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

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
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
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            transform: scale(1.1);
            background-color: #4169e1;
            transition-duration: 0.3s;
        }

        .btn:active {
            transform: scale(0.9);
            background-color: blue; 
            transition-duration: 0.3s;
        }
    </style>
</head>
<body>
<h1>Gestión Integral</h1>

        <table class="main-table" border="1">
            <thead>
                <tr>
                    <th colspan="5">Habitaciones</th>
                    <th colspan="9">Reservas</th>
                </tr>
                <tr>
                    <td><strong>Nº Hab.</strong></td>
                    <td><strong>Tipo</strong></td>
                    <td><strong>Cap.</strong></td>
                    <td><strong>Operación</strong></td>
                    <td><strong>Hoy</strong></td>
                    <td><strong>-1d</strong></td>
                    <td><strong>+1d</strong></td>
                    <td><strong>+2d</strong></td>
                    <td><strong>+3d</strong></td>
                    <td><strong>+4d</strong></td>
                    <td><strong>+5d</strong></td>
                    <td><strong>+6d</strong></td>
                    <td><strong>+1d</strong></td>
                </tr>
            </thead>
            <tbody align="center">
                <!-- Aquí se añadirán dinámicamente las filas de las habitaciones -->
                <?php

                    if ($result->num_rows > 0) {
                        // Salida de cada fila
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["numero"] . "</td>
                                <td>" . $row["tipo"] . "</td>
                                <td>" . $row["capacidad"] . "</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No hay habitaciones</td></tr>";
                    }

                    $conn->close();
                ?>
            </tbody>
        </table>
        
        <table class="main-table" border="1">
            <thead>
                <tr>
                    <td colspan="12"><strong>Plazas</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Total</td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td rowspan="3"></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td><?php echo $plazas['total_plazas']; ?></td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2">Usadas</td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                    <td><?php echo $plazas['plazas_usadas']; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Libres</td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                    <td><?php echo $plazas['plazas_libres']; ?></td>
                </tr>
            </thead>
        </table>

    <a href="formulario_habitaciones.php" class="btn">Añadir Habitación</a>

</body>
</html>
