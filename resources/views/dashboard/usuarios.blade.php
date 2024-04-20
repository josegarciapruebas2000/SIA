@extends('base')

@section('content')
    <h2 style="text-align: center">Usuarios</h2>
    <br><br>

    <div class="row mb-3 justify-content-end">
        <div class="col-auto">
            <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <div class="col-auto">
            <a href="{{ route('registrar.usuario') }}">
                <button type="button" class="btn btn-primary btn-sm mb-2 mb-sm-0">Agregar</button>
            </a>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-secondary btn-sm mb-2 mb-sm-0" onclick="window.history.back()">Regresar</button>
        </div>
    </div>

    <br>
    <form class="centered-form">
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

                <!-- Cuerpo de la tabla -->
                <tbody>
                    <!-- Iteración sobre los usuarios -->
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
                                    <form method="POST" action="{{ route('usuarios.toggle', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        @if ($user->status)
                                            <button type="submit" class="btn btn-outline-secondary btn-sm mx-1">Deshabilitar</button>
                                        @else
                                            <button type="submit" class="btn btn-outline-success btn-sm mx-1">Habilitar</button>
                                        @endif
                                    </form>
                                    <a href="/profile" style="text-decoration: none;">
                                        <button type="button" class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                    </a>
                                    <form method="POST" action="{{ route('usuarios.delete', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm mx-1">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </form>

    <style>
        /* Regla de estilo para los botones dentro de .button-container */
        .button-container button {
            margin-bottom: 5px; /* Margen inferior para separar verticalmente los botones */
        }

        /* Regla de estilo para centrar el texto en las celdas y encabezados de la tabla */
        .table tbody tr td,
        .table thead tr th {
            text-align: center;
            padding: 8px; /* Ajusta el espaciado entre el contenido y los bordes de las celdas */
        }

        /* Regla de estilo para centrar verticalmente las filas de la tabla */
        .align-middle {
            vertical-align: middle;
        }

        /* Ajuste de espaciado entre columnas */
        .table th,
        .table td {
            padding: 0.75rem; /* Ajusta el espaciado entre las columnas */
        }

        /* Ajuste de altura de los botones */
        .btn-sm {
            height: 30px; /* Ajusta la altura de los botones pequeños */
        }

        /* Regla de estilo específica para dispositivos móviles */
        @media (max-width: 991.98px) {
            .button-container button {
                margin-bottom: 10px; /* Incrementa el margen inferior en dispositivos móviles */
            }
        }
    </style>

    <div class="pagination justify-content-end">
        <!-- Paginación -->
        {{ $users->links() }}
    </div>
@endsection
