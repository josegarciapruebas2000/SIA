@extends('base')

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
        <h4 style="text-align: inherit">Solicitud de viaticos</h4>
        <br>
        <form class="centered-form">
            <div class="row mb-3">
                <div class="col">
                    <label for="grupo" class="form-label">Proyecto:</label>
                    <br>
                    <label for="grupo" class="form-label">Usuario:</label>
                    <br>
                    <label for="grupo" class="form-label">Periodo:</label>
                </div>
            </div>

            <div class="row mb-2">
                <label for="tutor" class="form-label">Comentario:</label>
                <div class="col">
                    <input type="text" class="form-control" id="comentario" name="comentario"
                        placeholder="Ingrese comentarios" required>
                </div>

                <div class="col">
                    <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                        <button type="submit" class="btn btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <!-- Icono SVG con clase de tamaño y color blanco -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="bi me-2" width="24"
                                height="24">
                                <path fill="#ffffff"
                                    d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z" />
                            </svg>
                            <!-- Texto del botón -->
                            Aceptar </button>

                        <button type="button" class="btn btn-danger">Rechazar</button>
                    </div>
                </div>

            </div>


            <br>

            <table class="table table-striped">
                <thead class="table-header">
                    <tr>
                        <th scope="col" style="background-color: #4772C6; color: white; border-radius: 8px 0 0 0;">ID
                        </th>
                        <th scope="col" style="background-color: #4772C6; color: white;">Revisor</th>
                        <th scope="col" style="background-color: #4772C6; color: white;">Comentario</th>
                        <th scope="col" style="background-color: #4772C6; color: white; border-radius: 0 8px 0 0;">Fecha
                            y hora</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>


        </form>
    </div>
@endsection
