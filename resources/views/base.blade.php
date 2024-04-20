<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para el botón de menú */
        #menu-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 9999;
            background-color: transparent;
            border: none;
        }

        /* Estilos para la barra de navegación */
        .navbar {
            position: relative; /* Agrega posición relativa para los elementos absolutos */
        }

        /* Estilos para el sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            left: -250px; /* Cambia la posición inicial para que esté fuera de la pantalla */
            height: 100vh;
            width: 250px;
            background-color: rgba(0, 8, 44, 255);
            color: white;
            transition: left 0.3s ease; /* Cambia la propiedad de transición */
            z-index: 999;
            overflow-x: hidden;
        }

        /* Estilo para mostrar el sidebar */
        #sidebar.show-sidebar {
            left: 0; /* Cambia la posición cuando se muestra */
        }

        /* Estilo para el contenido principal */
        #content-container {
            margin-left: 0; /* Elimina el margen izquierdo */
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Estilos para el contenido principal */
        .main-content {
            padding: 20px;
            min-height: 80vh;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
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
            max-width: 100px;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                left: -250px; /* Cambia la posición inicial para que esté fuera de la pantalla */
                transition: left 0.3s ease; /* Cambia la propiedad de transición */
            }

            #sidebar.show-sidebar {
                left: 0; /* Cambia la posición cuando se muestra */
            }

            #menu-toggle {
                display: block;
                position: absolute; /* Cambia a posición absoluta */
                top: 50%;
                transform: translateY(-50%);
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
            <button id="menu-toggle" onclick="toggleSidebar()" class="btn btn-dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px;">
                    <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" fill="currentColor" />
                </svg>
            </button>
            <ul class="navbar-nav ml-auto">
                @if (session('user'))
                    <li class="nav-item">
                        <a class="nav-link" style="color: #ffffff" id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                            {{ session('user')->name }} ({{ session('user')->role }})
                        </a>
                    </li>
                @endif
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
                        <li><a class="dropdown-item" href="/profile">Editar Perfil</a></li>
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

        <ul class="nav flex-column" style="padding-left: 20px;">
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/#">Clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/#">Proyectos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/usuarios">Usuarios</a>
            </li>
        </ul>

    </div>

    <div class="card shadow border">
        <div id="content-container" class="card-body">
            <div class="main-content">
                <!-- Área de contenido dinámico -->
                @yield('content')
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
