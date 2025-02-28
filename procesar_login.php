<?php
session_start();
require 'conexion.php';
require 'config.php'; // Configuración para conexión y envío de correos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el correo existe en la base de datos
    $sql = "SELECT usuario_id, nombre, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verificar contraseña
        if (password_verify($password, $row['password'])) {
            // Crear un token único para MFA
            $token = bin2hex(random_bytes(50)); // Genera un token seguro
            $expira = date("Y-m-d H:i:s", strtotime("+15 minutes")); // El token expira en 15 minutos

            // Guardar el token en la base de datos
            $stmt = $conn->prepare("UPDATE usuarios SET token = ?, token_expira = ? WHERE email = ?");
            $stmt->bind_param("sss", $token, $expira, $email);
            $stmt->execute();

            // Enviar el correo con el enlace de MFA
            $enlace = "http://localhost/sistemabd/verify_mfa.php?token=" . $token . "&email=" . urlencode($email) . "&nombre=" . urlencode($row['nombre']);
            $asunto = "Verificación de identidad";
            $mensaje = "Haz clic en el siguiente enlace para verificar tu identidad: $enlace";
            $cabeceras = "From: uts@gerardo.com\r\nContent-Type: text/html;";

            mail($email, $asunto, $mensaje, $cabeceras);

            echo "Se ha enviado un enlace de verificación a tu correo.";

            // Guardar datos del usuario en sesión para la siguiente fase (MFA)
            $_SESSION['usuario'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='login.php';</script>";
    }
}
?>
