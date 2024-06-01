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
        // Verificar si solo un nivel tiene el valor de 1 y los demás 0
        elseif (
            ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 0 && $solicitud->aceptadoNivel3 == 0) ||
            ($solicitud->aceptadoNivel1 == 0 && $solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel3 == 0) ||
            ($solicitud->aceptadoNivel1 == 0 && $solicitud->aceptadoNivel2 == 0 && $solicitud->aceptadoNivel3 == 1)
        ) {
            $estado = 'Aceptada';
        }
        // Verificar si la solicitud ha sido aceptada en todos los niveles
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

        <a href="{{ route('generar.cheque', ['id'=>$solicitud->FOLIO_via]) }}" class="btn btn-danger">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="bi me-2" width="24" height="24">
                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#ffffff"
                    d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0 0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z" />
            </svg>
            Solicitud de cheque electrónico
        </a>

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
