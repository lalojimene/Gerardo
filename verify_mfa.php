<?php
session_start();
require 'conexion.php'; // Conexión a la base de datos

if (isset($_GET['token']) && isset($_GET['email']) && isset($_GET['nombre'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];
    $nombre_usuario = $_GET['nombre'];

    // Verificar si el token existe en la base de datos y no ha expirado
    $sql = "SELECT usuario_id, nombre, token_expira FROM usuarios WHERE token = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verificar si el token ha expirado
        $expira = new DateTime($row['token_expira']);
        $ahora = new DateTime();
        
        if ($expira > $ahora) {
            // Mostrar formulario de verificación
            echo "<h2>Verificación de identidad</h2>";
            echo "<p>Nombre de usuario: <strong>$nombre_usuario</strong></p>";  // Aquí mostramos el nombre de usuario
            echo "<form action='verify_mfa.php' method='POST'>
                    <input type='hidden' name='token' value='$token'>
                    <input type='hidden' name='email' value='$email'>
                    <input type='hidden' name='nombre' value='$nombre_usuario'>
                    <button type='submit' name='verify' value='yes'>Sí, soy yo</button>
                    <button type='submit' name='verify' value='no'>No, no soy yo</button>
                  </form>";
        } else {
            echo "El enlace de verificación ha expirado. Intenta iniciar sesión de nuevo.";
        }
    } else {
        echo "Token inválido o ya utilizado.";
    }
} else {
    echo "No se ha proporcionado un token válido.";
}

if (isset($_POST['verify'])) {
    $token = $_POST['token'];
    $email = $_POST['email'];
    $nombre_usuario = $_POST['nombre'];

    if ($_POST['verify'] == 'yes') {
        // El usuario ha confirmado que es él
        // Eliminar el token de la base de datos
        $stmt = $conn->prepare("UPDATE usuarios SET token = NULL, token_expira = NULL WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        // Iniciar sesión y redirigir a la página principal
        $_SESSION['usuario'] = $nombre_usuario;  // Guardamos el nombre de usuario
        $_SESSION['email'] = $email;
        header("Location: principal.php");
        exit();
    } else {
        // El usuario ha rechazado la verificación
        echo "Acceso rechazado. Si no eres tú, por favor contacta con soporte.";
    }
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
    }

    .form-container {
        width: 50%;
        margin: 0 auto;
        background: white;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
