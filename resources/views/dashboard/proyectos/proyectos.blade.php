@extends('base')

<style>
    .icon-lupa {
        fill: rgb(255, 255, 255);
        /* Cambia "your-color" al color que desees */
    }

    .row-red {
        background-color: #f8d7da;
        /* Color de fondo rojo */
    }
</style>

@section('content')
    <h2 style="text-align: center">Proyectos</h2>
    <br><br>

    <div class="row mb-3">
        <div class="col">
            <form action="{{ route('proyectos.lista') }}" method="GET" class="input-group">
                <input type="text" class="form-control" placeholder="Buscar" name="search" style="max-width: 350px;">
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="icon-lupa" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
                        height="16">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="col-md-auto">
            <div class="row">
                <div class="col-auto mb-3 mb-md-0" style="margin-bottom: 20px; padding-top: 20px;">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#agregarModal">Agregar</button>
                </div>
                <div class="col-auto" style="margin-bottom: 20px; padding-top: 20px;">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-outline-secondary btn-sm">Regresar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <li class="page-item {{ $proyectos->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $proyectos->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
            @for ($i = 1; $i <= $proyectos->lastPage(); $i++)
                <li class="page-item {{ $proyectos->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $proyectos->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $proyectos->currentPage() == $proyectos->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $proyectos->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
        </ul>
    </nav>

    <form class="centered-form">
        <!-- Mostrar la alerta solo si hay un mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <!-- Cuerpo de la tabla -->
            <table class="table table-striped">
                <!-- Encabezado de la tabla -->
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Nombre</th>
                        <th scope="col" class="text-center">Monto</th>
                        <th scope="col" class="text-center">Moneda</th>
                        <th scope="col" class="text-center">Inicio</th>
                        <th scope="col" class="text-center">Fin</th>
                        <th scope="col" class="text-center">Cliente</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Iteración sobre los proyectos -->
                    @foreach ($proyectos as $proyecto)
                        <tr @if ($proyecto->status == 0) class="table-danger" @endif>
                            <td class="text-center align-middle">{{ $proyecto->idProy }}</td>
                            <td class="text-center align-middle">{{ $proyecto->nombreProy }}</td>
                            <td class="text-center align-middle">{{ $proyecto->montoProy }}</td>
                            <td class="text-center align-middle">{{ $proyecto->monedaProy }}</td>
                            <td class="text-center align-middle">{{ $proyecto->fechaInicio }}</td>
                            <td class="text-center align-middle">{{ $proyecto->fechaFin }}</td>
                            <td class="text-center align-middle">{{ $proyecto->cliente->nombre }}</td>
                            <td class="text-center align-middle"> <!-- Alineación vertical -->
                                @if ($proyecto->status == 1)
                                    <a href="{{ route('proyectos.toggleStatus', ['id' => $proyecto->idProy]) }}"
                                        class="btn btn-outline-secondary">Deshabilitar</a>
                                @else
                                    <a href="{{ route('proyectos.toggleStatus', ['id' => $proyecto->idProy]) }}"
                                        class="btn btn-outline-success">Habilitar</a>
                                @endif
                                <button type="button" class="btn btn-outline-warning btn-sm mx-1 btn-editar"
                                    data-bs-toggle="modal" data-bs-target="#editarModal{{ $proyecto->idProy }}"
                                    data-proyecto-id="{{ $proyecto->idProy }}">Editar</button>
                                <a href="{{ route('proyectos.eliminar', ['id' => $proyecto->idProy]) }}"
                                    class="btn btn-outline-danger btn-sm mx-1">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </form>


    <!-- Agregar un identificador al modal -->
    <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarModalLabel">Agregar Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor del mensaje de error -->
                    <div id="errorMensaje" class="alert alert-danger" style="display: none;"></div>

                    <!-- Contenido del formulario para agregar un proyecto -->
                    <form action="{{ route('add.proyectos') }}" method="POST" id="formularioProyecto">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="monto">Monto:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" id="monto" name="monto"
                                                aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="moneda">Moneda:</label>
                                    <select class="form-control" id="moneda" name="moneda">
                                        <option value="MX">MX</option>
                                        <option value="US">US</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col text-center">
                                <label for="generacion" class="form-label">Periodo:</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col" style="text-align: center;">
                                <label for="fecha_inicio" class="form-label">Inicio:</label>
                                <div class="input-group">
                                    <input id="fecha_inicio" type="text" class="form-control"
                                        placeholder="Seleccione una fecha" name="fecha_inicio"
                                        value="{{ old('fecha_inicio') }}"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                                </div>
                            </div>
                            <div class="col" style="text-align: center;">
                                <label for="fecha_fin" class="form-label">Fin:</label>
                                <div class="input-group">
                                    <input id="fecha_fin" type="text" class="form-control"
                                        placeholder="Seleccione una fecha" name="fecha_fin"
                                        value="{{ old('fecha_fin') }}"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label for="idCliente">Cliente:</label>
                            <select class="form-control" id="idCliente" name="idCliente" required>
                                <option value="">Seleccionar</option>
                                @foreach ($clientes->where('status', 1) as $cliente)
                                    <option value="{{ $cliente->idCliente }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="usuarios">Asignar proyecto a usuarios:</label>
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#usuariosCollapse" aria-expanded="false"
                                aria-controls="usuariosCollapse">
                                <i class="fas fa-users me-2"></i> Seleccionar usuarios
                            </button>
                            <div class="collapse" id="usuariosCollapse">
                                <div class="list-group mt-3" style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($usuarios->where('status', 1) as $usuario)
                                        <div class="list-group-item border-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $usuario->id }}" id="usuario{{ $usuario->id }}"
                                                    name="usuarios[]">
                                                <label class="form-check-label ms-2" for="usuario{{ $usuario->id }}">
                                                    {{ $usuario->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary ms-2"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para editar proyectos -->
    @foreach ($proyectos as $proyecto)
        <div class="modal fade" id="editarModal{{ $proyecto->idProy }}" tabindex="-1"
            aria-labelledby="editarModalLabel{{ $proyecto->idProy }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel{{ $proyecto->idProy }}">Editar Proyecto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenedor del mensaje de error -->
                        <div id="errorMensajeEditar{{ $proyecto->idProy }}" class="alert alert-danger"
                            style="display: none;"></div>

                        <!-- Contenido del formulario para editar un proyecto -->
                        <form action="{{ route('update.proyectos', ['id' => $proyecto->idProy]) }}" method="POST"
                            id="formularioEditarProyecto{{ $proyecto->idProy }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre{{ $proyecto->idProy }}" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre{{ $proyecto->idProy }}"
                                    name="nombre" value="{{ $proyecto->nombreProy }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="monto{{ $proyecto->idProy }}" class="form-label">Monto:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="monto{{ $proyecto->idProy }}"
                                            name="monto" aria-label="Amount (to the nearest dollar)"
                                            value="{{ $proyecto->montoProy }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="moneda{{ $proyecto->idProy }}" class="form-label">Moneda:</label>
                                    <select class="form-select" id="moneda{{ $proyecto->idProy }}" name="moneda">
                                        <option value="MX" {{ $proyecto->monedaProy == 'MX' ? 'selected' : '' }}>MX
                                        </option>
                                        <option value="US" {{ $proyecto->monedaProy == 'US' ? 'selected' : '' }}>US
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="row mb-3">
                                <div class="col text-center">
                                    <label for="generacion" class="form-label">Periodo:</label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col" style="text-align: center;">
                                    <label for="fecha_inicio" class="form-label">Inicio:</label>
                                    <div class="input-group">
                                        <input id="fecha_inicio" type="text" class="form-control"
                                            placeholder="Seleccione una fecha" name="fecha_inicio"
                                            value="{{ $proyecto->fechaInicio }}"
                                            style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    </div>
                                </div>
                                <div class="col" style="text-align: center;">
                                    <label for="fecha_fin" class="form-label">Fin:</label>
                                    <div class="input-group">
                                        <input id="fecha_fin" type="text" class="form-control"
                                            placeholder="Seleccione una fecha" name="fecha_fin"
                                            value="{{ $proyecto->fechaFin }}"
                                            style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="mb-3">
                                <label for="cliente{{ $proyecto->idProy }}" class="form-label">Cliente:</label>
                                <select class="form-select" id="cliente{{ $proyecto->idProy }}" name="idCliente">
                                    <option value="">Seleccionar</option>
                                    @foreach ($clientes->where('status', 1) as $cliente)
                                        <option value="{{ $cliente->idCliente }}"
                                            {{ $cliente->idCliente == $proyecto->idClienteProy ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <br>

                            <div class="form-group">
                                <label for="usuarios">Usuarios asociados:</label>
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#usuariosCollapse" aria-expanded="false"
                                    aria-controls="usuariosCollapse">
                                    <i class="fas fa-users me-2"></i> Ver usuarios
                                </button>
                                <div class="collapse" id="usuariosCollapse">
                                    <div class="list-group mt-3" style="max-height: 200px; overflow-y: auto;">
                                        @foreach ($pivotes->where('idProyecto', $proyecto->idProy) as $pivot)
                                            @php
                                                $usuario = $usuarios->where('id', $pivot->idUsuario)->first();
                                            @endphp
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $usuario->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">{{ $usuario->email }}</h6>
                                                    <p class="card-text">Rol: {{ $usuario->role }}</p>
                                                    <!-- Agrega más campos aquí según tu modelo de usuario -->
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>


                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary ms-2"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script para ocultar la alerta después de 3 segundos -->
    <script>
        // Ocultar la alerta después de 3 segundos
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);

        // Función para validar y guardar el proyecto
        function guardarProyecto() {
            var nombreProyecto = document.getElementById('nombre').value;
            var montoProyecto = document.getElementById('monto').value;
            var monedaProyecto = document.getElementById('moneda').value;
            var fechaInicioProyecto = document.getElementById('fecha_inicio').value;
            var fechaFinProyecto = document.getElementById('fecha_fin').value;
            var idClienteProyecto = document.getElementById('idCliente').value;
            var errorMensaje = document.getElementById('errorMensaje');

            // Reiniciar el mensaje de error
            errorMensaje.innerHTML = '';
            errorMensaje.style.display = 'none';

            // Validar el campo de nombre
            if (nombreProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese el nombre del proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            // Validar el campo de monto
            if (montoProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese el monto del proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            // Validar el campo de moneda
            if (monedaProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese la moneda del proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            // Validar los campos de fecha de inicio y fin
            if (fechaInicioProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese la fecha de inicio del proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            if (fechaFinProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese la fecha de fin del proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            // Validar el campo de ID del cliente
            if (idClienteProyecto.trim() === '') {
                errorMensaje.innerHTML = 'Por favor seleccione un cliente para el proyecto';
                errorMensaje.style.display = 'block';
                return;
            }

            // Si todas las validaciones pasan, enviar el formulario
            document.getElementById('formularioProyecto').submit();
        }
    </script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        // Inicializar Flatpickr en español
        flatpickr("#fecha_inicio", {
            dateFormat: "Y-m-d",
            locale: "es",
            onClose: function(selectedDates) {
                // Configurar la fecha mínima para la fecha de fin
                if (selectedDates.length > 0) {
                    flatpickr("#fecha_fin", {
                        minDate: selectedDates[0],
                        dateFormat: "Y-m-d",
                        locale: "es"
                    });
                }
            }
        });
    </script>
@endsection
