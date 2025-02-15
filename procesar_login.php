<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT usuario_id, nombre, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['usuario'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];
            header("Location: principal.php"); // Redirige al usuario a principal.php
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='login.php';</script>";
    }
}
?>
