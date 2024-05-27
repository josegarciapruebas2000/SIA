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

    .table tbody tr td {
        vertical-align: middle;
    }
</style>

@section('content')
    <h2 style="text-align: center">Autorización - Resumen</h2>
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

    <br>

    <div class="table-responsive table-container active-table" id="solicitud-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Folio</th>
                    <th scope="col">Solicitud del viático</th>
                    <th scope="col">Beneficiario</th>
                    <th scope="col">Total</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if ($solicitudes->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No hay datos disponibles</td>
                    </tr>
                @else
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td scope="row">{{ $solicitud->FOLIO_via }}</td>
                            <td>{{ $solicitud->nombreSolicitud }}</td>
                            <td>{{ $solicitud->user->name }}</td>
                            <td>$ {{ number_format($solicitud->total_via, 2) }}</td>
                            <td>
                                {{ Carbon::parse($solicitud->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}
                                <strong> - </strong>
                                {{ Carbon::parse($solicitud->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}
                            </td>
                            <td>
                                <a style="text-decoration: none;"
                                    href="{{ route('revisarAutorizacionSolicitud', ['id' => $solicitud->FOLIO_via]) }}">
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
                    <!-- Agregar la fila con la suma total -->
                    <tr>
                        <td></td>
                        <td colspan="2" class="text-end font-weight-bold" style="font-weight: bold;">Total de viáticos:
                        </td>
                        <td class="text-left font-weight-bold" style="font-weight: bold;">$
                            {{ number_format($totalSum, 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>




    <div class="table-container" id="comprobacion-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre de la comprobación</th>
                    <th scope="col">Beneficiario</th>
                    <th scope="col">Total</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <a style="text-decoration: none;" href="{{ route('autorizarComprobacion') }}">
                            <button type="button" class="btn btn-lg btn-primary" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path fill="#ffffff"
                                        d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                            </button>
                        </a>
                        <button type="button" class="btn btn-success">3/3</button>

                    </td>
                </tr>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <button type="button" class="btn btn-lg btn-primary" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-primary">2/3</button>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <button type="button" class="btn btn-lg btn-primary" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20" height="20 ">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free -->
                                <path fill="#ffffff"
                                    d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container" id="reposicion-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre de la reposición</th>
                    <th scope="col">Beneficiario</th>
                    <th scope="col">Total</th>
                    <th scope="col">Fecha</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <a style="text-decoration: none;" href="{{ route('autorizarReposicion') }}">
                            <button type="button" class="btn btn-lg btn-primary" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24"
                                    height="24">
                                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path fill="#ffffff"
                                        d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                </svg>
                            </button>
                        </a>
                        <button type="button" class="btn btn-success">3/3</button>

                    </td>
                </tr>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <button type="button" class="btn btn-lg btn-primary" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-primary">2/3</button>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Herramientas y Equipos</td>
                    <td>Pemex</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>@26-03-24</td>
                    <td>
                        <button type="button" class="btn btn-lg btn-primary" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                            </svg>
                        </button>
                        <button type="button" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20" height="20 ">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free -->
                                <path fill="#ffffff"
                                    d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        @endif
    </script>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('.filter-btn').click(function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');

            var target = $(this).data('target');
            $('.table-container').removeClass('active-table');
            $('#' + target + '-table').addClass('active-table');
        });
    });
</script>
