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
        if (password_verify($password, $row['password'])) {
            // Generar token de MFA
            $token_mfa = bin2hex(random_bytes(50));
            $expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

            $stmt = $conn->prepare("UPDATE usuarios SET token = ?, token_expira = ? WHERE email = ?");
            $stmt->bind_param("sss", $token_mfa, $expira, $email);
            $stmt->execute();

            // Enviar correo con el enlace de MFA
            $enlace = "http://localhost/sistemabd/verify_mfa.php?token=" . $token_mfa . "&email=" . urlencode($email) . "&nombre=" . urlencode($row['nombre']);
            mail($email, "Verificación de identidad", "Haz clic en este enlace: $enlace", "From: uts@gerardo.com\r\nContent-Type: text/html;");

            echo "Se ha enviado un enlace de verificación a tu correo.";
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='login.php';</script>";
    }
}
?>