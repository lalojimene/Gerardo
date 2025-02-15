<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow-lg">
                    <h3 class="text-center mb-3">Registro</h3>

                    <form action="procesar_registro.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Casilla de aceptación de los Términos y Condiciones -->
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="aceptar_terminos" id="aceptar_terminos" required>
                            <label class="form-check-label" for="aceptar_terminos">Acepto los <a href="terminos_y_condiciones.php" target="_blank">Términos y Condiciones</a></label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>

                    <p class="mt-3 text-center">
                        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Asegura que el botón de registro esté habilitado solo si se ha marcado la casilla
        const form = document.querySelector("form");
        const checkbox = document.getElementById("aceptar_terminos");
        const submitButton = form.querySelector('button[type="submit"]');

        checkbox.addEventListener("change", function () {
            submitButton.disabled = !this.checked;
        });

        // Deshabilitar el botón al cargar la página si la casilla no está marcada
        submitButton.disabled = !checkbox.checked;
    </script>
</body>
</html>
