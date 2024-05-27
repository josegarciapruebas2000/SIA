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
    <h2 style="text-align: center">Autorización</h2>
    <hr style="border-top: 6px solid #2e2d2d; margin: 20px 0; height: 2px; border-radius: 3px;">
    <div class="col text-end">
        <a href="{{ route('autorizar') }}" style="text-decoration: none;" class="btn btn-secondary">
            Regresar
        </a>
    </div>
    <div style="border: 2px solid #2e2d2d92; padding: 20px; margin: 20px; border-radius: 8px;">
        <h4 style="text-align: inherit"><strong>Solicitud de viaticos</strong></h4>
        <br>
        <div class="centered-form">
            <div class="row mb-3">
                <div class="col">
                    <label for="grupo" class="form-label"><strong>Folio:</strong>
                        {{ $solicitud->FOLIO_via }}</label>
                    <br>
                    <label for="grupo" class="form-label"><strong>Proyecto:</strong>
                        {{ $solicitud->proyecto->nombreProy }}</label>
                    <br>
                    <label for="grupo" class="form-label"><strong>Usuario:</strong> {{ $solicitud->user->name }}</label>
                    <br>
                    <label for="grupo" class="form-label"><strong>Comentario:</strong>
                        {{ $solicitud->comentario_via }}</label>
                    <br>
                    <label for="grupo" class="form-label"><strong>Periodo:</strong>
                        {{ Carbon::parse($solicitud->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}
                        <strong> - </strong>
                        {{ Carbon::parse($solicitud->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}</label>
                </div>
            </div>

            <div class="row mb-2">
                <form action="{{ route('comentarios_revisor.agregar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idRevisor" value="{{ auth()->user()->id }}">
                    <!-- Verifica que auth()->user()->idRevisor está disponible -->
                    <input type="hidden" name="folioSoli" value="{{ $solicitud->FOLIO_via }}">
                    <!-- Verifica que $solicitud->FOLIO_via está disponible -->
                    <label for="comentarioRevisor" class="form-label"><strong>Comentario de revisor:</strong></label>
                    <div class="col">
                        <div class="input-group">
                            <input type="text" class="form-control" id="comentarioRevisor" name="comentario"
                                placeholder="Ingrese un comentario antes de aceptar o rechazar" required>
                            <button type="submit" class="btn btn-primary d-block d-sm-inline-block">Agregar</button>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="col text-end">
                    <div class="d-flex justify-content-end flex-wrap">
                        <!-- Botón para aceptar -->
                        <form method="POST" action="{{ route('actualizar_estado', ['id' => $solicitud->FOLIO_via]) }}"
                            class="me-2 mb-2">
                            @csrf
                            <button type="submit" name="estado" value="aceptar" class="btn btn-primary">
                                Aceptar
                            </button>
                        </form>

                        <!-- Botón para rechazar -->
                        <form method="POST" action="{{ route('actualizar_estado', ['id' => $solicitud->FOLIO_via]) }}"
                            class="mb-2">
                            @csrf
                            <button type="submit" name="estado" value="rechazar" class="btn btn-danger">
                                Rechazar
                            </button>
                        </form>
                    </div>
                </div>



            </div>


            <br>

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

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        
        @if(session('error'))
            Swal.fire({
                icon: 'warning',
                title: 'No has agregado comentarios',
                text: '{{ session('error') }}',
            });
        @endif

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        @endif
    </script>
    
@endsection
