@extends('base')

<style>
    .icon-lupa {
        fill: rgb(255, 255, 255);
        /* Cambia "your-color" al color que desees */
    }
</style>

@section('content')
    <h2 style="text-align: center">Usuarios</h2>
    <br><br>

    <div class="row mb-3">
        <div class="col">
            <form action="{{ route('usuarios.lista') }}" method="GET" class="input-group">
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
                    <a href="{{ route('registrar.usuario') }}">
                        <button type="button" class="btn btn-primary btn-sm">Agregar</button>
                    </a>
                </div>
                <div class="col-auto" style="margin-bottom: 20px; padding-top: 20px;">
                    <a href="{{ route('dashboard') }}">
                        <button type="button" class="btn btn-outline-secondary btn-sm">Regresar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>    

    <div class="row mb-3">

        <div class="col">
            <form action="{{ route('usuarios.lista') }}" method="GET" class="input-group">
                <select class="form-select" name="filter" style="max-width: 150px;">
                    <option value="todos" {{ request('filter') == 'todos' ? 'selected' : '' }}>Todos</option>
                    <option value="activos" {{ request('filter') == 'activos' ? 'selected' : '' }}>Activos</option>
                    <option value="inactivos" {{ request('filter') == 'inactivos' ? 'selected' : '' }}>Inactivos</option>
                    <option value="revisores" {{ request('filter') == 'revisores' ? 'selected' : '' }}>Revisores</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        <div class="col">
            <!-- Paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only"></span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                        <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only"></span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <form class="centered-form">
        <!-- Mostrar la alerta solo si hay un mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <!-- Encabezado de la tabla -->
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Nombre</th>
                        <th scope="col" class="text-center">Correo</th>
                        <th scope="col" class="text-center">Rol</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Iteración sobre los usuarios o mensaje de no hay datos -->
                    @if ($users->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay datos disponibles.</td>
                        </tr>
                    @else
                        @foreach ($users as $user)
                            <tr class="{{ $user->status ? '' : 'table-danger' }} align-middle">
                                <td class="text-center">{{ $user->id }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->role }}</td>
                                <td class="text-center">{{ $user->status ? 'Habilitado' : 'Deshabilitado' }}</td>
                                <td class="text-center">
                                    <!-- Botones de acción -->
                                    <div class="button-container d-flex justify-content-center justify-content-sm-end">
                                        @if ($user->status)
                                            <button type="button" class="btn btn-outline-secondary btn-sm mx-1"
                                                onclick="toggleUsuario({{ $user->id }})">Deshabilitar</button>
                                        @else
                                            <button type="button" class="btn btn-outline-success btn-sm mx-1"
                                                onclick="toggleUsuario({{ $user->id }})">Habilitar</button>
                                        @endif
                                        <a href="{{ route('editar.usuario', ['id' => $user->id]) }}"
                                            style="text-decoration: none;">
                                            <button type="button"
                                                class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                        </a>
                                        <form id="deleteForm{{ $user->id }}" method="POST"
                                            action="{{ route('usuarios.delete', ['id' => $user->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm mx-1">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </form>

    <style>
        /* Estilos adicionales aquí */
    </style>



    <!-- Script para ocultar la alerta después de 3 segundos -->
    <script>
        // Ocultar la alerta después de 3 segundos
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);
    </script>

    <script>
        function toggleUsuario(userId) {
            fetch("{{ url('usuarios') }}/" + userId + "/toggle", {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Actualizar la página después de la solicitud exitosa
                        window.location.reload();
                    } else {
                        // Manejar errores en la solicitud
                        console.error('Error al procesar la solicitud');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
