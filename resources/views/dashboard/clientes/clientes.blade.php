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
    <h2 style="text-align: center">Clientes</h2>
    <br><br>

    <div class="row mb-3">
        <div class="col">
            <form action="{{ route('clientes.lista') }}" method="GET" class="input-group">
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
            <li class="page-item {{ $clientes->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $clientes->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
            @for ($i = 1; $i <= $clientes->lastPage(); $i++)
                <li class="page-item {{ $clientes->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $clientes->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $clientes->currentPage() == $clientes->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $clientes->nextPageUrl() }}" aria-label="Next">
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
                        <th scope="col" class="text-center">Categoria</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Iteración sobre los clientes -->
                    @foreach ($clientes as $cliente)
                        @php
                            // Verificar si el cliente tiene proyectos asociados
                            $proyectosAsociados = App\Models\Proyecto::where(
                                'idClienteProy',
                                $cliente->idCliente,
                            )->exists();
                        @endphp
                        <tr @if ($cliente->status == 0) class="table-danger" @endif>
                            <td class="text-center align-middle">{{ $cliente->idCliente }}</td>
                            <td class="text-center align-middle">{{ $cliente->nombre }}</td>
                            <td class="text-center align-middle">{{ $cliente->CategoriaCliente }}</td>
                            <td class="text-center align-middle"> <!-- Alineación vertical -->
                                @if ($cliente->status == 1)
                                    <a href="{{ route('clientes.toggleStatus', ['id' => $cliente->idCliente]) }}"
                                        class="btn btn-outline-secondary">Deshabilitar</a>
                                @else
                                    <a href="{{ route('clientes.toggleStatus', ['id' => $cliente->idCliente]) }}"
                                        class="btn btn-outline-success">Habilitar</a>
                                @endif
                                <button type="button" class="btn btn-outline-warning btn-sm mx-1 btn-editar"
                                    data-bs-toggle="modal" data-bs-target="#editarModal{{ $cliente->idCliente }}"
                                    data-cliente-id="{{ $cliente->idCliente }}">Editar</button>
                                @unless ($proyectosAsociados)
                                    <a href="{{ route('eliminar.cliente', ['id' => $cliente->idCliente]) }}"
                                        class="btn btn-outline-danger btn-sm mx-1">Eliminar</a>
                                @endunless
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
                    <h5 class="modal-title" id="agregarModalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor del mensaje de error -->
                    <div id="errorMensaje" class="alert alert-danger" style="display: none;"></div>

                    <!-- Contenido del formulario para agregar un cliente -->
                    <form action="{{ route('add.clientes') }}" method="POST" id="formularioCliente">
                        @csrf
                        <div class="form-group">
                            <label for="categoria">Categoría:</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="Seleccionar">Seleccionar</option>
                                <option value="CFE">CFE</option>
                                <option value="Pemex">Pemex</option>
                                <option value="Privada">Privada</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" onclick="guardarCliente()">Guardar</button>
                            <button type="button" class="btn btn-secondary ms-2"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para editar clientes -->
    @foreach ($clientes as $cliente)
        <div class="modal fade" id="editarModal{{ $cliente->idCliente }}" tabindex="-1"
            aria-labelledby="editarModalLabel{{ $cliente->idCliente }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel{{ $cliente->idCliente }}">Editar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del formulario para editar un cliente -->
                        <form action="{{ route('update.clientes', ['id' => $cliente->idCliente]) }}" method="POST"
                            id="formularioEditarCliente{{ $cliente->idCliente }}">
                            @csrf
                            @method('PUT')
                            <!-- Contenido del formulario -->
                            <div class="form-group">
                                <label for="categoria{{ $cliente->idCliente }}">Categoría:</label>
                                <select class="form-select" id="categoria{{ $cliente->idCliente }}" name="categoria">
                                    <option value="CFE" {{ $cliente->CategoriaCliente === 'CFE' ? 'selected' : '' }}>
                                        CFE</option>
                                    <option value="Pemex" {{ $cliente->CategoriaCliente === 'Pemex' ? 'selected' : '' }}>
                                        Pemex</option>
                                    <option value="Privada"
                                        {{ $cliente->CategoriaCliente === 'Privada' ? 'selected' : '' }}>Privada</option>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="nombre{{ $cliente->idCliente }}">Nombre:</label>
                                <input type="text" class="form-control" id="nombre{{ $cliente->idCliente }}"
                                    name="nombre" value="{{ $cliente->nombre }}">
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

        // Función para validar y guardar el cliente
        function guardarCliente() {
            var categoriaSeleccionada = document.getElementById('categoria').value;
            var nombreCliente = document.getElementById('nombre').value;
            var errorMensaje = document.getElementById('errorMensaje');

            // Reiniciar el mensaje de error
            errorMensaje.innerHTML = '';
            errorMensaje.style.display = 'none';

            // Validar la selección de categoría
            if (categoriaSeleccionada === 'Seleccionar') {
                errorMensaje.innerHTML = 'Por favor seleccione una categoría';
                errorMensaje.style.display = 'block';
                return;
            }

            // Validar el campo de nombre
            if (nombreCliente.trim() === '') {
                errorMensaje.innerHTML = 'Por favor ingrese el nombre del cliente';
                errorMensaje.style.display = 'block';
                return;
            }

            // Si todas las validaciones pasan, enviar el formulario
            document.getElementById('formularioCliente').submit();
        }

        // Función para cargar el modal de edición
        $(document).ready(function() {
            $('.btn-editar').click(function() {
                var clienteId = $(this).data('cliente-id');
                var modalId = '#editarModal' + clienteId;

                // Mostrar el modal correspondiente
                $(modalId).modal('show');
            });
        });
    </script>
@endsection
