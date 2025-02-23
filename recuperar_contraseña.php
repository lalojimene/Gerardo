<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevaPassword = password_hash($_POST['nueva_password'], PASSWORD_BCRYPT);
    $celular = $_SESSION['celular'];

    $sql = "UPDATE usuarios SET password = ? WHERE celular = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nuevaPassword, $celular);

    if ($stmt->execute()) {
        echo "Contraseña restablecida correctamente.";
        session_destroy();
    } else {
        echo "Error al actualizar la contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow-lg">
                    <h3 class="text-center mb-3">Restablecer Contraseña</h3>
                    <form action="restablecer_contraseña.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" name="nueva_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Restablecer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
