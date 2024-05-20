<?php
// Iniciar sesión
session_start();

include "conexion.php";
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT id FROM usuarios_hotel WHERE correo = '$email' AND clave_hashed = '$password'";
    $result = $conn->query($sql);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($result->num_rows > 0) {
        // Obtener el ID del usuario
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        
        // Guardar el ID del usuario en la sesión
        $_SESSION['id'] = $user_id;
        
        // Redireccionar al usuario a la página de inicio de sesión exitosa
        header("Location: main.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, redireccionar al usuario a la página de inicio de sesión de nuevo
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        #enviar {
            text-align: center; /* Para centrar horizontalmente */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px; /* Altura para centrar verticalmente */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            width: 20%; /* Ancho ajustado */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        input[type="submit"]:active {
            background-color: blue;
            transform: scale(0.9);
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group" id="enviar">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </div>
</body>
</html>
