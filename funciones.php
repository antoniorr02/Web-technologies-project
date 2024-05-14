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
    
    $sql = "SELECT * FROM usuarios";
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
function modificar_usuario($id, $nombre, $apellidos, $tarjeta, $dni, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $clave, $datos, $tipo_usuario) {
    global $conn;
    
    // Hash de la contraseña
    $hashed_clave = password_hash($clave, PASSWORD_DEFAULT);
    
    // Preparar la declaración
    $stmt = $conn->prepare("UPDATE usuarios_hotel SET nombre = ?, apellidos = ?, tarjeta = ?, dni = ?, nacionalidad = ?, fecha_nacimiento = ?, sexo = ?, correo = ?, clave = ?, datos = ?, tipo_usuario WHERE id = ?");
    
    // Vincular parámetros
    $stmt->bind_param("ssssssssssi", $nombre, $apellidos, $tarjeta, $dni, $nacionalidad, $fecha_nacimiento, $sexo, $correo, $hashed_clave, $datos, $tipo_usuario, $id);

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
?>

