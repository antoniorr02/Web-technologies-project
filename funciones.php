<?php
include 'conexion.php';

// Función para insertar un usuario
function insertar_usuario($nombre, $apellidos, $dni, $tarjeta, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $clave, $datos, $tipo_usuario) {
    global $conn;
    
    // Hash de la contraseña
    $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);

    // Preparar la declaración
    $stmt = $conn->prepare("INSERT INTO usuarios_hotel (nombre, apellidos, dni, tarjeta_credito, nacionalidad, fecha_nacimiento, sexo, correo, clave_hashed, datos, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Vincular parámetros
    $stmt->bind_param("sssssssssss", $nombre, $apellidos, $tarjeta, $dni, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $hashed_clave, $datos, $tipo_usuario);

    $stmt->execute();
}

// Función para obtener todos los usuarios
function obtener_usuarios() {
    global $conn;
    
    $sql = "SELECT * FROM usuarios_hotel";
    $result = $conn->query($sql);
    
    $usuarios = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    
    return $usuarios;
}

/*
PARA MOSTRAR EL LISTADO DE USUARIOS:
$usuarios = obtener_usuarios();
foreach ($usuarios as $usuario) {
    echo "ID: " . $usuario['id'] . "<br>";
    echo "Nombre: " . $usuario['nombre'] . "<br>";
    echo "Apellidos: " . $usuario['apellidos'] . "<br>";
    echo "Tarjeta" . $usuario['tarjeta'] . "<br>";
    echo "DNI: " . $usuario['dni'] . "<br>";
    echo "Nacionalidad: " . $usuario['nacionalidad'] . "<br>";
    echo "Fecha de Nacimiento: " . $usuario['fecha_nacimiento'] . "<br>";
    echo "Sexo: " . $usuario['sexo'] . "<br>";
    echo "Correo: " . $usuario['correo'] . "<br>";
    echo "Datos: " . $usuario['datos'] . "<br>";
    echo "Tipo Usuario: " . $usuario['tipo_usuario] . "<br>";
    echo "<hr>"; // Línea divisoria entre usuarios
}
*/

// Función para borrar un usuario por su ID
function borrar_usuario($id) {
    global $conn;

    // Preparar la declaración
    $stmt = $conn->prepare("DELETE FROM usuarios_hotel WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("i", $id);

    $stmt->execute();
}

// Función para modificar un usuario
function modificar_usuario($id, $tarjeta, $correo, $clave) {
    global $conn;
    
    // Hash de la contraseña
    $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);
    
    // Preparar la declaración
    $stmt = $conn->prepare("UPDATE usuarios_hotel SET tarjeta_credito = ?, correo = ?, clave_hashed = ? WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("sssi", $tarjeta, $correo, $hashed_clave, $id);

    $stmt->execute();
}

function obtener_usuario_por_id($id_usuario) {
    global $conn;
    // Consulta SQL para obtener los datos del usuario por su ID
    $sql = "SELECT * FROM usuarios_hotel WHERE id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param('i', $id_usuario);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Obtener los datos del usuario
    $usuario = $result->fetch_assoc();

    // Liberar el resultado
    $result->free();

    // Devolver los datos del usuario
    return $usuario;
}

function luhn($tarjeta) {
    // Eliminar espacios en blanco y caracteres no numéricos
    $tarjeta = preg_replace('/\D/', '', $tarjeta);

    // Convertir la cadena en un array de dígitos
    $digitos = str_split(strrev($tarjeta));

    $suma = 0;
    $doble = false;

    foreach ($digitos as $digito) {
        // Convertir el dígito a entero
        $digito = intval($digito);

        // Si el dígito está en una posición impar, se duplica
        if ($doble) {
            $digito *= 2;

            // Si el resultado de la multiplicación es mayor que 9, se resta 9
            if ($digito > 9) {
                $digito -= 9;
            }
        }

        // Sumar el dígito a la suma total
        $suma += $digito;

        // Alternar entre doblar y no doblar en cada iteración
        $doble = !$doble;
    }

    // Si la suma total es un múltiplo de 10, la tarjeta es válida
    return $suma % 10 === 0;
}

// Función para insertar una habitación
function insertar_habitacion($numero_habitacion, $capacidad, $precio_noche, $descripcion) {
    global $conn;

    // Preparar la declaración
    $stmt = $conn->prepare("INSERT INTO habitaciones_hotel (numero_habitacion, capacidad, precio_noche, descripcion) VALUES (?, ?, ?, ?)");
    
    // Vincular parámetros
    $stmt->bind_param("sids", $numero_habitacion, $capacidad, $precio_noche, $descripcion);

    $stmt->execute();
}

// Función para obtener todas las habitaciones
function obtener_habitaciones() {
    global $conn;
    
    $sql = "SELECT * FROM habitaciones_hotel";
    $result = $conn->query($sql);
    
    $habitaciones = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $habitaciones[] = $row;
        }
    }
    
    return $habitaciones;
}

// Función para borrar una habitación por su ID
function borrar_habitacion($id_habitacion) {
    global $conn;

    // Preparar la declaración
    $stmt = $conn->prepare("DELETE FROM habitaciones_hotel WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("i", $id_habitacion);

    $stmt->execute();
}

// Función para modificar una habitación
function modificar_habitacion($id_habitacion, $numero_habitacion, $capacidad, $precio_noche, $descripcion) {
    global $conn;
    
    // Preparar la declaración
    $stmt = $conn->prepare("UPDATE habitaciones_hotel SET numero_habitacion = ?, capacidad = ?, precio_noche = ?, descripcion = ? WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("sidsi", $numero_habitacion, $capacidad, $precio_noche, $descripcion, $id_habitacion);

    $stmt->execute();
}

// Función para obtener una habitación por su ID
function obtener_habitacion_por_id($id_habitacion) {
    global $conn;
    
    // Consulta SQL para obtener los datos de la habitación por su ID
    $sql = "SELECT * FROM habitaciones_hotel WHERE id = ?";
    
    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    
    // Vincular parámetros
    $stmt->bind_param('i', $id_habitacion);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    
    // Obtener los datos de la habitación
    $habitacion = $result->fetch_assoc();
    
    // Liberar el resultado
    $result->free();
    
    // Devolver los datos de la habitación
    return $habitacion;
}

function obtener_imagenes_habitacion($habitacion_id) {
    global $conn;

    // Consulta SQL para obtener las imágenes de la habitación por su ID
    $sql = "SELECT * FROM fotos_habitacion WHERE habitacion_id = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param('i', $habitacion_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Inicializar un array para almacenar las imágenes
    $imagenes = array();

    // Recorrer el resultado y almacenar las imágenes en el array
    while ($row = $result->fetch_assoc()) {
        $imagenes[] = $row;
    }

    // Liberar el resultado
    $result->free();

    // Devolver las imágenes de la habitación
    return $imagenes;
}

// Función para eliminar una foto por su ID
function eliminar_foto($id_foto) {
    global $conn;

    // Preparar la declaración
    $stmt = $conn->prepare("DELETE FROM fotos_habitacion WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("i", $id_foto);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se eliminó correctamente
    if ($stmt->affected_rows > 0) {
        return true; // La foto se eliminó correctamente
    } else {
        return false; // No se pudo eliminar la foto
    }
}

function registrar_evento($descripcion, $user_id = null) {
    global $conn;
    $sql = "INSERT INTO logs (descripcion, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $descripcion, $user_id);
    $stmt->execute();
    $stmt->close();
}

function buscar_habitaciones_adecuadas($huespedes, $fecha_entrada, $fecha_salida, $user_id = null) {
    global $conn;

    // Iniciar transacción
    mysqli_autocommit($conn, false);

    try {
        // Consulta para encontrar habitaciones disponibles que coincidan con los criterios de búsqueda
        $sql = "SELECT * FROM habitaciones_hotel
                WHERE capacidad >= ? 
                AND id NOT IN (
                    SELECT id_habitacion FROM reservas 
                    WHERE estado = 'Pendiente' 
                    AND (fecha_entrada BETWEEN ? AND ? 
                         OR fecha_salida BETWEEN ? AND ?)
                )";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issss', $huespedes, $fecha_entrada, $fecha_salida, $fecha_entrada, $fecha_salida);
        $stmt->execute();
        $result = $stmt->get_result();
        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);

        // Registrar el evento
        $descripcion = "Buscando habitaciones adecuadas para $huespedes personas, del $fecha_entrada al $fecha_salida.";
        registrar_evento($descripcion, $user_id);

        // Confirmar transacción
        mysqli_commit($conn);

        return $habitaciones;
    } catch (Exception $e) {
        // Si hay algún error, revertir transacción
        mysqli_rollback($conn);
        throw $e;
    } finally {
        // Restaurar el comportamiento de autocommit
        mysqli_autocommit($conn, true);
    }
}

// FUNCIONES PARA ZONA LATERAL
function numero_habitaciones() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM habitaciones_hotel";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_habitaciones = $row["total"];
    } else {
        $total_habitaciones = 0;
    }
    return $total_habitaciones;
}

function obtenerNumeroHabitacionesLibres() {
    global $conn;

    // Fecha actual
    $fechaActual = date('Y-m-d');

    // Consulta SQL para contar todas las habitaciones
    $sqlTotalHabitaciones = "SELECT COUNT(*) AS total FROM habitaciones_hotel";
    $resultTotal = $conn->query($sqlTotalHabitaciones);

    // Consulta SQL para contar las habitaciones reservadas actualmente
    $sqlHabitacionesOcupadas = "
        SELECT COUNT(DISTINCT id_habitacion) AS ocupadas
        FROM reservas
        WHERE fecha_entrada <= '$fechaActual' AND fecha_salida >= '$fechaActual'
        AND estado = 'Confirmada'
    ";
    $resultOcupadas = $conn->query($sqlHabitacionesOcupadas);

    if ($resultTotal->num_rows > 0 && $resultOcupadas->num_rows > 0) {
        $rowTotal = $resultTotal->fetch_assoc();
        $rowOcupadas = $resultOcupadas->fetch_assoc();

        $totalHabitaciones = $rowTotal["total"];
        $habitacionesOcupadas = $rowOcupadas["ocupadas"];

        // Calcular el número de habitaciones libres
        $habitacionesLibres = $totalHabitaciones - $habitacionesOcupadas;
    } else {
        $habitacionesLibres = numero_habitaciones();
    }

    // Devolver el número de habitaciones libres
    return $habitacionesLibres;
}

function capacidad_total() {
    global $conn;
    $sql = "SELECT * FROM habitaciones_hotel";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $capacidad = 0;
        while($row = $result->fetch_assoc()) {
            $capacidad += $row['capacidad'];
        }
    } else {
        $capacidad = 0;
    }
    return $capacidad;
}

function obtenerNumeroHuespedesAlojados() {
    global $conn;

    // Fecha actual
    $fechaActual = date('Y-m-d');

    // Consulta SQL para obtener las habitaciones ocupadas actualmente
    $sqlHabitacionesOcupadas = "
        SELECT h.capacidad
        FROM reservas r
        JOIN habitaciones_hotel h ON r.id_habitacion = h.id
        WHERE r.fecha_entrada <= '$fechaActual' AND r.fecha_salida >= '$fechaActual'
        AND r.estado = 'Confirmada'
    ";
    $resultOcupadas = $conn->query($sqlHabitacionesOcupadas);

    $totalHuespedes = 0;

    if ($resultOcupadas) {
        while ($row = $resultOcupadas->fetch_assoc()) {
            $totalHuespedes += $row['capacidad'];
        }
    }

    return $totalHuespedes;
}

// Función para obtener las reservas activas
function obtener_reservas_activas($id_cliente) {
    global $conn;
    $fecha_actual = date('Y-m-d');
    $sql = "SELECT * FROM reservas WHERE id_cliente = ? AND fecha_entrada >= ? AND estado = 'Confirmada'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $id_cliente, $fecha_actual);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservas = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $reservas;
}

// Función para obtener el historial de reservas
function obtener_historial_reservas($id_cliente) {
    global $conn;
    $fecha_actual = date('Y-m-d');
    $sql = "SELECT * FROM reservas WHERE id_cliente = ? AND fecha_entrada < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $id_cliente, $fecha_actual);
    $stmt->execute();
    $result = $stmt->get_result();
    $historial = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $historial;
}

?>