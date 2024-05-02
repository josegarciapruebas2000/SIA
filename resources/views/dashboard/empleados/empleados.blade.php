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

    .icon-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .icon-button svg path {
        fill: #808080;
        /* Gris */
    }

    .icon-button:hover svg path {
        fill: rgb(41, 41, 94);
        /* Azul al pasar el mouse */
    }
</style>

@section('content')
    <h2 style="text-align: center">Lista de empleados</h2>
    <br><br>

    <div class="row mb-3">
        <div class="col">
            <form action="{{ route('empleados.lista') }}" method="GET" class="input-group">
                <input type="text" class="form-control" placeholder="Buscar" name="search" style="max-width: 350px;">
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="icon-lupa" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16"
                        height="16">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </button>
            </form>
            <br>
            <form id="filtro-form" action="{{ route('empleados.lista') }}" method="GET" class="input-group mb-3"
                style="width: 30%;">
                <label class="input-group-text" for="filtro-departamento">Filtro por departamento:</label>
                <select class="form-select text-capitalize" id="filtro-departamento" name="filtro_departamento"
                    onchange="submitForm()">
                    <option value="Todos" {{ request()->input('filtro_departamento') == 'Todos' ? 'selected' : '' }}>Todos
                    </option>
                    <option value="RRHH" {{ request()->input('filtro_departamento') == 'RRHH' ? 'selected' : '' }}>Rrhh
                    </option>
                    <option value="Compras" {{ request()->input('filtro_departamento') == 'Compras' ? 'selected' : '' }}>
                        Compras</option>
                    <option value="Sistemas" {{ request()->input('filtro_departamento') == 'Sistemas' ? 'selected' : '' }}>
                        Sistemas</option>
                    <option value="Calidad" {{ request()->input('filtro_departamento') == 'Calidad' ? 'selected' : '' }}>
                        Calidad</option>
                    <option value="Ventas" {{ request()->input('filtro_departamento') == 'Ventas' ? 'selected' : '' }}>
                        Ventas</option>
                    <option value="Almacen" {{ request()->input('filtro_departamento') == 'Almacen' ? 'selected' : '' }}>
                        Almacen</option>
                    <option value="Operaciones"
                        {{ request()->input('filtro_departamento') == 'Operaciones' ? 'selected' : '' }}>Operaciones
                    </option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
            </form>
        </div>
        <div class="col-md-auto">
            <div class="row">
                <div class="col-auto mb-3 mb-md-0" style="margin-bottom: 20px; padding-top: 20px;">
                    <a href="{{ route('alta.empleado') }}">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#agregarModal">Agregar</button></a>
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
            <li class="page-item {{ $empleados->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $empleados->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only"></span>
                </a>
            </li>
            @for ($i = 1; $i <= $empleados->lastPage(); $i++)
                <li class="page-item {{ $empleados->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $empleados->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $empleados->currentPage() == $empleados->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $empleados->nextPageUrl() }}" aria-label="Next">
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
                        <th scope="col" class="text-center">Nombre del empleado</th>
                        <th scope="col" class="text-center">Puesto</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Iteración sobre los proyectos -->
                    @foreach ($empleados as $empleado)
                        <tr @if ($empleado->status == 0) class="table-danger" @endif>
                            <td class="text-center align-middle">{{ $empleado->id_Emp }}</td>
                            <td class="text-center align-middle"> {{ $empleado->nombre_Emp }}
                                {{ $empleado->app_paterno_Emp }} {{ $empleado->app_materno_Emp }}</td>
                            <td class="text-center align-middle">{{ $empleado->puesto_Emp }}</td>
                            <td class="text-center align-middle"> <!-- Alineación vertical -->
                                @if ($empleado->status == 1)
                                    <a href="{{ route('empleados.toggleStatus', ['id' => $empleado->id_Emp]) }}"
                                        class="btn btn-outline-secondary">Deshabilitar</a>
                                @else
                                    <a href="{{ route('empleados.toggleStatus', ['id' => $empleado->id_Emp]) }}"
                                        class="btn btn-outline-success">Habilitar</a>
                                @endif

                                <a style="text-decoration: none;"
                                    href="{{ route('cargar.empleado', ['id' => $empleado->id_Emp]) }}">
                                    <button type="button" class="btn btn-outline-warning mx-1 btn-editar">Editar</button>
                                </a>

                                <a href="{{ route('documentos.empleado', ['id' => $empleado->id_Emp]) }}" class="icon-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                        <path
                                            d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z" />
                                    </svg>
                                </a>
                                
                                

                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </form>

    <!-- Script para ocultar la alerta después de 3 segundos -->
    <script>
        // Ocultar la alerta después de 3 segundos
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);

        // Función para enviar el formulario automáticamente
        function submitForm() {
            document.getElementById("filtro-form").submit();
        }
    </script>
@endsection
