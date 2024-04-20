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
                <button type="button" class="btn btn-primary mb-2 mb-sm-0">Agregar</button>
            </a>
        </div>
        <div class="col-auto">
            <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">Regresar</button>
            </div>
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
                        <th scope="col"></th>
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
                            <td>
                                <!-- Botones de acción -->
                                <div class="button-container">
                                    @if ($user->status)
                                        <button type="button" class="btn btn-outline-secondary">Deshabilitar</button>
                                    @else
                                        <button type="button" class="btn btn-outline-success">Habilitar</button>
                                    @endif
                                    <a href="/profile" style="text-decoration: none;">
                                        <button type="button" class="btn btn-outline-warning">Editar</button>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger">Eliminar</button>
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
        }

        /* Regla de estilo para centrar verticalmente las filas de la tabla */
        .align-middle {
            vertical-align: middle;
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
