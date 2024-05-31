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
        border-color: #484747 !important;
        color: #000000 !important;
    }

    .custom-color:hover {
        background-color: #676767 !important;
        border-color: #212529 !important;
        color: #ffffff !important;
    }

    .custom-color.active {
        background-color: rgba(0, 8, 44, 255) !important;
        color: white !important;
        border-color: #555556 !important;
    }

    .table-container {
        display: none;
    }

    .active-table {
        display: block;
    }
</style>

@section('content')
    <h2 style="text-align: center">Historial de gastos</h2>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="btn-group d-flex flex-wrap" role="group" aria-label="Filter Options">
                    <button type="button" class="btn btn-outline-primary filter-btn active custom-color flex-fill mb-2"
                        data-target="solicitud">Solicitud</button>
                    <button type="button" class="btn btn-outline-primary filter-btn custom-color flex-fill mb-2"
                        data-target="comprobacion">Comprobación</button>
                    <button type="button" class="btn btn-outline-primary filter-btn custom-color flex-fill mb-2"
                        data-target="reposicion">Reposición</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-group .btn {
            margin: 5px;
            /* Añadir un pequeño margen entre los botones para una mejor separación */
        }
    </style>

    <br>

    <div class="table-container active-table" id="solicitud-table">

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $solicitudes->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>
                @for ($i = 1; $i <= $solicitudes->lastPage(); $i++)
                    <li class="page-item {{ $solicitudes->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $solicitudes->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $solicitudes->currentPage() == $solicitudes->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $solicitudes->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Folio</th>
                        <th scope="col">Nombre de la solicitud</th>
                        <th scope="col">Beneficiario</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Total</th>
                        <th scope="col">Fecha</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($solicitudes->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">No hay datos disponibles</td>
                        </tr>
                    @else
                        @foreach ($solicitudes as $solicitud)
                            <tr class="text-center">
                                <td>{{ $solicitud->FOLIO_via }}</td>
                                <td>{{ $solicitud->nombreSolicitud }}</td>
                                <td>{{ $solicitud->user->name }}</td>
                                <td>{{ $solicitud->proyecto->cliente->nombre }}</td>
                                <td>{{ $solicitud->proyecto->nombreProy }}</td>
                                <td>$ {{ number_format($solicitud->total_via, 2) }}</td>
                                <td>
                                    <div class="container">
                                        <div class="row">
                                            <div
                                                class="col-12 d-flex flex-column flex-md-row justify-content-center align-items-center">
                                                <span class="mb-2 mb-md-0">
                                                    {{ Carbon::parse($solicitud->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}
                                                </span>
                                                <strong class="mx-2">-</strong>
                                                <span>
                                                    {{ Carbon::parse($solicitud->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a style="text-decoration: none;"
                                        href="{{ route('historial.solicitud', ['id' => $solicitud->FOLIO_via]) }}">
                                        <button type="button" class="btn btn-lg btn-primary" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                                height="24">
                                                <path fill="#ffffff"
                                                    d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                            </svg>
                                        </button>
                                    </a>

                                    @if ($solicitud->aceptadoNivel1 == 2 || $solicitud->aceptadoNivel2 == 2 || $solicitud->aceptadoNivel3 == 2)
                                        <button type="button" class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20"
                                                height="20">
                                                <path fill="#ffffff"
                                                    d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                                            </svg>
                                        </button>
                                    @elseif ($solicitud->aceptadoNivel3 == 1 && $solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel1 == 1)
                                        <button type="button" class="btn btn-success">3/3</button>
                                    @elseif ($solicitud->aceptadoNivel3 == 1 && $solicitud->aceptadoNivel2 == 1)
                                        <button type="button" class="btn btn-success">3/3</button>
                                    @elseif ($solicitud->aceptadoNivel2 == 1 && $solicitud->aceptadoNivel1 == 0)
                                        <button type="button" class="btn btn-primary">2/3</button>
                                    @elseif ($solicitud->aceptadoNivel1 == 1 && $solicitud->aceptadoNivel2 == 1)
                                        <button type="button" class="btn btn-primary">2/3</button>
                                    @elseif ($solicitud->aceptadoNivel1 == 1)
                                        <button type="button" class="btn btn-dark">1/3</button>
                                    @elseif ($solicitud->aceptadoNivel3 == 1 && $solicitud->aceptadoNivel2 == 0 && $solicitud->aceptadoNivel1 == 0)
                                        <button type="button" class="btn btn-success">3/3</button>
                                    @else
                                        <button type="button" class="btn btn-warning">Pendiente</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <style>
                .text-center {
                    text-align: center;
                }

                .mb-2 {
                    margin-bottom: 0.5rem;
                }

                .mb-md-0 {
                    margin-bottom: 0;
                }

                .mx-2 {
                    margin-left: 0.5rem;
                    margin-right: 0.5rem;
                }
            </style>

        </div>
    </div>

    <div class="table-container" id="comprobacion-table">

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item {{ $comprobaciones->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $comprobaciones->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>
                @for ($i = 1; $i <= $comprobaciones->lastPage(); $i++)
                    <li class="page-item {{ $comprobaciones->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $comprobaciones->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li
                    class="page-item {{ $comprobaciones->currentPage() == $comprobaciones->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $comprobaciones->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only"></span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Folio</th>
                        <th scope="col">Nombre de la solicitud</th>
                        <th scope="col">Beneficiario</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Total</th>
                        <th scope="col">Fecha y hora</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comprobaciones as $comprobacion)
                        <tr class="text-center">
                            <td>{{ $comprobacion->folio_via }}</td>
                            <td>
                                {{ $comprobacion->solicitudViatico ? $comprobacion->solicitudViatico->nombreSolicitud : 'Solicitud no disponible' }}
                            </td>
                            <td>
                                {{ $comprobacion->solicitudViatico && $comprobacion->solicitudViatico->user ? $comprobacion->solicitudViatico->user->name : 'Beneficiario no disponible' }}
                            </td>
                            <td>
                                {{ $comprobacion->solicitudViatico && $comprobacion->solicitudViatico->proyecto->cliente ? $comprobacion->solicitudViatico->proyecto->cliente->nombre : 'Cliente no disponible' }}
                            </td>
                            <td>
                                {{ $comprobacion->solicitudViatico && $comprobacion->solicitudViatico->proyecto ? $comprobacion->solicitudViatico->proyecto->nombreProy : 'Proyecto no disponible' }}
                            </td>
                            <td>$ {{ number_format($comprobacion->monto_comprobado, 2) }}</td>
                            <td>
                                <div class="container">
                                    <div class="row">
                                        <div
                                            class="col-12 d-flex flex-column flex-md-row justify-content-center align-items-center">
                                            <span class="mb-2 mb-md-0">
                                                {{ Carbon::parse($comprobacion->fechaComprobacion)->translatedFormat('d \\ F \\ Y (H:i)') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a style="text-decoration: none;"
                                href="{{ route('historial.comprobacion', ['id' => $comprobacion->idComprobacion]) }}">
                                    <button type="button" class="btn btn-lg btn-primary" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                            height="24">
                                            <path fill="#ffffff"
                                                d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                        </svg>
                                    </button>
                                </a>

                                @if ($comprobacion->aceptadoNivel1 == 2 || $comprobacion->aceptadoNivel2 == 2 || $comprobacion->aceptadoNivel3 == 2)
                                    <button type="button" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20"
                                            height="20">
                                            <path fill="#ffffff"
                                                d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                                        </svg>
                                    </button>
                                @elseif ($comprobacion->aceptadoNivel3 == 1 && $comprobacion->aceptadoNivel2 == 1 && $comprobacion->aceptadoNivel1 == 1)
                                    <button type="button" class="btn btn-success">3/3</button>
                                @elseif ($comprobacion->aceptadoNivel3 == 1 && $comprobacion->aceptadoNivel2 == 1)
                                    <button type="button" class="btn btn-success">3/3</button>
                                @elseif ($comprobacion->aceptadoNivel2 == 1 && $comprobacion->aceptadoNivel1 == 0)
                                    <button type="button" class="btn btn-primary">2/3</button>
                                @elseif ($comprobacion->aceptadoNivel1 == 1 && $comprobacion->aceptadoNivel2 == 1)
                                    <button type="button" class="btn btn-primary">2/3</button>
                                @elseif ($comprobacion->aceptadoNivel1 == 1)
                                    <button type="button" class="btn btn-dark">1/3</button>
                                @elseif ($comprobacion->aceptadoNivel3 == 1 && $comprobacion->aceptadoNivel2 == 0 && $comprobacion->aceptadoNivel1 == 0)
                                    <button type="button" class="btn btn-success">3/3</button>
                                @else
                                    <button type="button" class="btn btn-warning">Pendiente</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay datos disponibles</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <div class="table-container" id="reposicion-table">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre de la solicitud</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">Herramientas y Equipos</td>
                        <td>Pemex</td>
                        <td>PRY-AJEB-SALAMANCA</td>
                        <td>@26-03-24</td>
                        <td>
                            <a style="text-decoration: none;" href="{{ route('historial.reposicion') }}">
                                <button type="button" class="btn btn-lg btn-primary" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                        height="24">
                                        <path fill="#ffffff"
                                            d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                </button>
                            </a>
                        </td>
                    </tr>
                    <!-- Repite la estructura para otras filas -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.filter-btn');
            var tables = document.querySelectorAll('.table-container');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    buttons.forEach(function(btn) {
                        btn.classList.remove('active');
                    });

                    // Add active class to clicked button
                    button.classList.add('active');

                    // Hide all tables
                    tables.forEach(function(table) {
                        table.classList.remove('active-table');
                    });

                    // Show the target table
                    var target = button.getAttribute('data-target') + '-table';
                    document.getElementById(target).classList.add('active-table');
                });
            });
        });
    </script>
@endsection
