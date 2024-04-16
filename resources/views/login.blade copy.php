<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
            border-radius: 0.4rem; /* Añadir borde redondeado */
        }
        .btn-block {
            width: 70%; /* Reducir el ancho del botón */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img3.webp" alt="Login image" class="img-fluid">
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <div>
                                        <div class="col-md-12">
                                            <div class="text-center mb-4">
                                                <img src="/img/logo.png" alt="Logo de la empresa" style="max-width: 200px;">
                                            </div>
                                        </div>
                                        <h2 class="text-center mb-4">Iniciar sesión</h2>
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <label for="email">Correo:</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label for="password">Contraseña:</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <br>
                                            <div class="text-center"> <!-- Añadir clase text-center -->
                                                <button type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
