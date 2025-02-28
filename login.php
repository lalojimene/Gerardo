<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow-lg">
                    <h3 class="text-center mb-3">Iniciar Sesión</h3>
                    
                    <form action="procesar_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>

                    <p class="mt-3 text-center">
                        <a href="opciones_recuperacion.php">¿Olvidaste tu contraseña?</a>
                    </p>
                    
                    <p class="mt-3 text-center">
                        ¿No tienes cuenta? <a href="register.php">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
