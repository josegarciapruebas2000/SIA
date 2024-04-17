<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: rgba(0,8,44,255); /* Cambiar el color de fondo del cuerpo a azul */
            color: white; /* Cambiar el color de texto a blanco */
        }
        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border-radius: 0.8rem; /* Añadir borde redondeado */
        }
        .btn-block {
            width: 50%; /* Reducir el ancho del botón */
        }
        .logo-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            z-index: 1;
            color: white; /* Cambiar el color del texto y del logo a blanco */
        }
        .logo-text {
            font-size: 14px;
            margin-left: 5px;
            font-weight: bold; /* Hacer el texto en negrita */
            margin-bottom: 0px;
        }
        .login-image {
            position: relative;
            z-index: 0; /* Asegurar que la imagen esté detrás del texto y el logo */
            filter: brightness(0.45); /* Aplicar filtro oscuro */
            width: 100%;
            height: auto;
        }
        .login-text-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }
        .login-text {
            margin-bottom: 15px; /* Ajustar el margen inferior de los textos */
            font-weight: normal; /* Quitar negrita */
        }
        .vertical-center {
            display: flex;
            align-items: center;
            height: 100vh; /* Establecer la altura al 100% de la ventana */
        }
        .centered-form {
          max-width: 90%;
          font-size: 1rem;
          margin: auto;
          padding: 20px;
          padding-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center vertical-center"> <!-- Agregar clase vertical-center aquí -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body position-relative">
                        <div class="row">
                            <div class="col-md-6 position-relative"> <!-- Añadir clase position-relative para posicionar el logo -->
                                <img style="border-radius: 8px;" src="/img/inicio-login.jpg" alt="Login image" class="img-fluid login-image">
                                <div class="login-text-container">
                                    <p class="login-text" style="font-weight: bold; font-size: 24px; -webkit-text-stroke: 1px rgb(68, 67, 67);">Bienvenidos</p>
                                    <p class="login-text" style="font-size: 18px;">Esta es la plataforma SIA</p>
                                    <hr style="border-top: 6px solid #ffffff; margin: 20px 0; height: 2px; border-radius: 8px;">
                                </div>                                
                                <div class="logo-container">
                                    <img src="/img/logo.png" alt="Logo de la empresa" style="max-width: 50px;">
                                    <p class="logo-text">AJEB</p>
                                </div>
                            </div>
                            <div class="col-md-6 centered-form">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <div style="width: 90%;"> <!-- Establecer el ancho del contenedor del formulario al 90% -->
                                        <h2 class="text-center mb-4">Iniciar sesión</h2>                                        
                                        <form action="#" method="post">
                                            <div class="form-group" style="width: 90%;"> <!-- Establecer el ancho de los campos del formulario al 90% -->
                                                <label for="email" style="margin-bottom: 15px;">Correo:</label> <!-- Ajustar el margen inferior -->
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electronico" required>
                                            </div>
                                            <br>
                                            <div class="form-group" style="width: 90%;"> <!-- Establecer el ancho de los campos del formulario al 90% -->
                                                <label for="password" style="margin-bottom: 15px;">Contraseña:</label> <!-- Ajustar el margen inferior -->
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                                            </div>
                                            <br>
                                            <div class="text-center">
                                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg btn-block">Entrar</a>
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
