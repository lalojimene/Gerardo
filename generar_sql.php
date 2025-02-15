<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root"; // 
$password = ""; 
$dbname = "gerardo_db"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Lista de usuarios
$usuarios = [
    ['nombre' => 'Gerardo', 'email' => 'gerardo@example.com', 'password' => 'clave123', 'rol' => 'usuario'],
    ['nombre' => 'Josue', 'email' => 'josue@example.com', 'password' => 'seguro456', 'rol' => 'usuario'],
    ['nombre' => 'Alexis', 'email' => 'alexis@example.com', 'password' => 'pass789', 'rol' => 'usuario'],
    ['nombre' => 'Yahir', 'email' => 'yahir@example.com', 'password' => 'yahir2024', 'rol' => 'usuario'],
    ['nombre' => 'Wilber', 'email' => 'wilber@example.com', 'password' => 'admin999', 'rol' => 'admin'],
];

foreach ($usuarios as $usuario) {
    // Cifrar la contraseña
    $hashedPassword = password_hash($usuario['password'], PASSWORD_DEFAULT);
    
    // Preparar la consulta SQL para insertar el usuario
    $sql = "INSERT INTO `usuarios` (`nombre`, `email`, `password`, `rol`, `created_at`) 
            VALUES ('" . $usuario['nombre'] . "', '" . $usuario['email'] . "', '" . $hashedPassword . "', '" . $usuario['rol'] . "', NOW())";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado correctamente para: " . $usuario['nombre'] . "<br>";
    } else {
        echo "Error al insertar el usuario " . $usuario['nombre'] . ": " . $conn->error . "<br>";
    }
}

// Cerrar la conexión
$conn->close();
?>
