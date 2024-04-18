@extends('base')

@section('content')
    <h2 style="text-align: center">Solicitud de Viáticos</h2>
    <br><br>
    <form class="centered-form">
        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Crear nueva solicitud:</label>
                <input type="text" class="form-control" id="solicitud" name="solicitud" placeholder="Ingrese solicitud"
                    oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="col">
                <label for="grupo" class="form-label">Proyecto:</label>
                <input type="text" class="form-control" id="proyecto" name="proyecto" placeholder="Ingrese proyecto"
                    oninput="this.value = this.value.toUpperCase()">
            </div>

        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="tutor" class="form-label">Comentario:</label>
                <input type="text" class="form-control" id="comentario" name="comentario"
                    placeholder="Ingrese comentarios" oninput="this.value = this.value.toUpperCase()">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col text-center">
                <label for="generacion" class="form-label">Periodo:</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col" style="text-align: center;">
                <label for="fecha_sesion" class="form-label">Inicio:</label>
                <div class="input-group">
                    <input id="fecha_sesion" type="text" class="form-control" placeholder="Seleccione una fecha"
                        name="fecha_sesion" value="{{ old('fecha_sesion') }}"
                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                </div>
            </div>
            <div class="col" style="text-align: center;">
                <label for="fecha_sesion" class="form-label">Fin:</label>
                <div class="input-group">
                    <input id="fecha_sesion" type="text" class="form-control" placeholder="Seleccione una fecha"
                        name="fecha_sesion" value="{{ old('fecha_sesion') }}"
                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                </div>
            </div>
        </div>
        

        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Revisor:</label>
                <select class="form-control">
                    <option>Seleccione una opción</option>
                    <option>Opción 1</option>
                    <option>Opción 2</option>
                    <option>Opción 3</option>
                </select>

            </div>
            <div class="col">
                <label for="grado" class="form-label">Total:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>

        </div>


        <br><br>


        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        // Inicializar Flatpickr en español
        flatpickr("#fecha_sesion", {
            dateFormat: "Y-m-d",
            locale: "es", // Establecer el idioma a español
        });
    </script>
@endsection
