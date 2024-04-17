<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para el botón de menú */
        #menu-toggle {
            display: none;
        }

        /* Estilos para el sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: rgba(0,8,44,255);
            color: white;
            transition: transform 0.3s ease;
            z-index: 999;
            overflow-x: hidden;
            transform: translateX(0);
            /* Por defecto, el sidebar estará visible en modo escritorio */
        }

        /* Estilo para mostrar el sidebar */
        #sidebar.show-sidebar {
            transform: translateX(0);
        }

        /* Estilo para el contenido principal */
        #content-container {
            margin-left: 250px;
            transition: margin-left 0.3s;
            width: calc(100% - 250px);
            /* Ajuste para el ancho del contenido */
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Estilos para el contenido principal */
        .main-content {
            padding: 20px;
            min-height: 80vh;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            /* Ajustar la transparencia para difuminar más la sombra */
        }

        /* Estilos para los enlaces del menú */
        #sidebar a {
            padding: 10px;
            display: block;
            color: white;
            text-decoration: none;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            max-width: 100px; /* Ajusta el tamaño máximo del logo según tus necesidades */
        }

        /* Estilos para dispositivos móviles */
        @media (max-width: 991.98px) {
            .navbar-nav {
                flex-direction: row !important;
            }

            .nav-item {
                margin-right: 10px;
            }

            #content-container {
                margin-left: 0;
                width: 100%;
            }

            #sidebar {
                width: 0;
                transition: width 0.3s ease; /* Añadir animación para el cambio de ancho */
            }

            #sidebar.show-sidebar {
                width: 250px;
            }

            #menu-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 9999;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a id="dashboard-title" class="navbar-brand" style="color: #343a4000">Dashboard</a>
            <button id="menu-toggle" onclick="toggleSidebar()" class="btn btn-dark" style="background-color: transparent; border: none; position: absolute; top: 50%; transform: translateY(-50%);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; vertical-align: middle;"><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" fill="currentColor"/></svg>
            </button>
                     
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Notificaciones
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Notificación 1</a></li>
                        <li><a class="dropdown-item" href="#">Notificación 2</a></li>
                        <li><a class="dropdown-item" href="#">Notificación 3</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Perfil
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Editar Perfil</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">Cerrar Sesión</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <div id="sidebar">
        <br><br><br>
        
        <div class="logo-container">
            <img src="/img/logo.png" alt="Logo de la empresa">
        </div>
        <h3 class="text-center">AJEB</h3>
        
        <ul class="nav flex-column" style="padding-left: 20px;"> <!-- Agrega un margen izquierdo de 20px -->
            <li class="nav-item">
                <a class="nav-link active" href="#">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Configuración</a>
            </li>
        </ul>
        
    </div>

    <div class="card shadow border">
        <div id="content-container" class="card-body">
            <div class="main-content">
                <h2 style="text-align: center">Bienvenido a la vista principal</h2>
                <p>Aquí ira la info</p>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show-sidebar');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
