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
    <h2 style="text-align: center">Reposición de gastos (aceptada)</h2>
    <br><br>
    <h3 style="text-align: center">Aceptado por:</h3>
    <br>
    <form class="centered-form">
        <div class="row mb-3">
            <div class="col">
                <label for="grupo" class="form-label">Proyecto:</label>
                <input type="text" class="form-control" id="comentario" name="proyecto" placeholder="Proyecto seleccionado"
                    readonly>
            </div>

            <div class="col">
                <label for="grupo" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="comentario" name="cliente" placeholder="Cliente seleccionado"
                    readonly>

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
                <div class="col" style="text-align: center;">
                    <label for="fecha_sesion" class="form-label">Inicio:</label>
                    <input type="text" class="form-control" id="inicio" name="inicio" readonly>
                </div>
                <div class="col" style="text-align: center;">
                    <label for="fecha_sesion" class="form-label">Fin:</label>
                    <input type="text" class="form-control" id="inicio" name="fin" readonly>
                </div>
            </div>
        </div>


        <br><br>



        <div class="row mb-3">
            <div class="col">
                <label for="tutor" class="form-label">Monto solicitado: _ _ _ _ _ _ _ _</label>
            </div>

        </div>

        <br><br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Revisor</th>
                    <th scope="col">Comentario</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Revisor 1</th>
                    <td>Comentarios</td>
                    <td>28-04-2024</td>
                </tr>
                <tr>
                    <th scope="row">Revisor 1</th>
                    <td>Comentarios</td>
                    <td>28-04-2024</td>
                </tr>
                <tr>
                    <th scope="row">Revisor 1</th>
                    <td>Comentarios</td>
                    <td>28-04-2024</td>
                </tr>
            </tbody>
        </table>


        <br><br>


        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <a href="{{ route('historial') }}">
                        <button type="button" class="btn btn-outline-danger">Cancelar</button>
                    </a>
                </div>
            </div>
    </form>
@endsection
