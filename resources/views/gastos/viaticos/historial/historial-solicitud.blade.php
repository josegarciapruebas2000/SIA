@extends('base')

@php
    use Carbon\Carbon;
@endphp

<style>
    body,
    html {
        height: 100%;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .filter-btn {
        margin-right: 10px;
    }

    .custom-color {
        background-color: #ffffff !important;
        /* Añadido !important */
        border-color: #484747 !important;
        /* Añadido !important */
        color: #000000 !important;
    }

    .custom-color:hover {
        background-color: #676767 !important;
        /* Añadido !important */
        border-color: #212529 !important;
        /* Añadido !important */
        color: #ffffff !important;
    }

    .custom-color.active {
        background-color: rgba(0, 8, 44, 255) !important;
        /* Añadido !important */
        color: white !important;
        border-color: #555556 !important;
        /* Añadido !important */
    }

    .table-container {
        display: none;
    }

    .active-table {
        display: block;
    }
</style>

@section('content')
    @php
        // Inicializamos el estado como 'Pendiente' por defecto
        $estado = 'Pendiente';

        // Verificar si la solicitud ha sido rechazada en algún nivel
        if ($solicitud->aceptadoNivel1 == 2 || $solicitud->aceptadoNivel2 == 2 || $solicitud->aceptadoNivel3 == 2) {
            $estado = 'Rechazada';
        }
        // Verificar si la solicitud ha sido aceptada en el nivel necesario
        elseif ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel3 == 1) {
            $estado = 'Aceptada';
        }
    @endphp

    <h2 style="text-align: center">Solicitud de gastos ({{ $estado }})</h2>
    <div class="row justify-content-center">
        <div class="col text-end">
            <a href="{{ route('historial') }}" style="text-decoration: none;" class="btn btn-secondary">
                Regresar
            </a>
        </div>
    </div>

    <h3 style="text-align: center">Aceptado por:</h3>
    <br>
    <form class="centered-form">
        <div class="row mb-3">
            <div class="col">
                <label for="grupo" class="form-label">Proyecto:</label>
                <input type="text" class="form-control" id="comentario" name="proyecto"
                    value="{{ $solicitud->proyecto->nombreProy }}" readonly>
            </div>

            <div class="col">
                <label for="grupo" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="comentario" name="cliente" placeholder="Cliente seleccionado"
                    value="{{ $solicitud->proyecto->cliente->nombre }}" readonly>

            </div>

        </div>
        <br>
        <br>

        <div class="col">
            <div class="row mb-3">
                <div class="col text-center">
                    <label for="generacion" class="form-label">Periodo:</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <label for="fecha_sesion" class="form-label">Inicio:</label>
                    <input type="text" class="form-control text-center" id="inicio" name="inicio"
                        value="{{ Carbon::parse($solicitud->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}"
                        readonly>
                </div>

                <div class="col" style="text-align: center;">
                    <label for="fecha_sesion" class="form-label">Fin:</label>
                    <input type="text" class="form-control text-center" id="fin" name="fin"
                        value="{{ Carbon::parse($solicitud->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}"
                        readonly>
                </div>
            </div>
        </div>


        <br><br>



        <div class="row mb-3">
            <div class="col">
                <label for="tutor" class="form-label">
                    <h5>
                        <strong>Monto solicitado: $
                            {{ $solicitud->total_via }}
                        </strong>
                    </h5>
                </label>
            </div>

        </div>

        <br><br>

        <div class="table-responsive">
            <table class="table table-striped text-center align-middle">
                <thead class="table-header">
                    <tr>
                        <th scope="col" style="background-color: #4772C6; color: white; border-radius: 8px 0 0 0;">
                            Revisor</th>
                        <th scope="col" style="background-color: #4772C6; color: white;">Nivel</th>
                        <th scope="col" style="background-color: #4772C6; color: white;">Rol</th>
                        <th scope="col" style="background-color: #4772C6; color: white;">Comentario</th>
                        <th scope="col" style="background-color: #4772C6; color: white; border-radius: 0 8px 0 0;">
                            Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($comentarios->isEmpty())
                        <tr>
                            <td colspan="5">No hay datos disponibles.</td>
                        </tr>
                    @else
                        @foreach ($comentarios as $comentario)
                            <tr>
                                <td>{{ $comentario->revisor->name }}</td>
                                <td>{{ $comentario->revisor->nivel }}</td>
                                <td>{{ $comentario->revisor->role }}</td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $comentario->comentario }}</td>
                                <td>{{ date('d/m/Y', strtotime($comentario->fecha_hora)) }}
                                    ({{ date('H:i', strtotime($comentario->fecha_hora)) }})
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </form>
@endsection
