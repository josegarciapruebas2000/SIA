@extends('base')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

@section('content')
    <h2 style="text-align: center">Solicitud de Viáticos</h2>
    <br><br>
    <form class="centered-form" action="{{ route('guardar.solicitud') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Crear nueva solicitud:</label>
                <input type="text" class="form-control" id="solicitud" name="solicitud" placeholder="Ingrese solicitud"
                    required>
            </div>
            <div class="col">
                <label for="proyecto" class="form-label">Proyecto:</label>
                <select class="form-control" name="proyecto" id="proyecto" required>
                    <option value="">Seleccione un proyecto</option>
                    @foreach ($proyectos as $proyecto)
                        <option value="{{ $proyecto->idProy }}" data-inicio="{{ $proyecto->fechaInicio }}"
                            data-fin="{{ $proyecto->fechaFin }}">{{ $proyecto->nombreProy }}</option>
                    @endforeach
                </select>


            </div>



        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="tutor" class="form-label">Comentario:</label>
                <input type="text" class="form-control" id="comentario" name="comentario"
                    placeholder="Ingrese comentarios" required>
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col text-center">
                <label for="generacion" class="form-label">Periodo:</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col" style="text-align: center;">
                <label for="fecha_inicio" class="form-label">Inicio:</label>
                <div class="input-group">
                    <input id="fecha_inicio" type="text" class="form-control" placeholder="Seleccione una fecha"
                        name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                </div>
            </div>
            <div class="col" style="text-align: center;">
                <label for="fecha_fin" class="form-label">Fin:</label>
                <div class="input-group">
                    <input id="fecha_fin" type="text" class="form-control" placeholder="Seleccione una fecha"
                        name="fecha_fin" value="{{ old('fecha_fin') }}"
                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                </div>
            </div>
        </div>


        <br><br>

        <div class="row mb-3">
            <div class="col">
                <label for="revisor" class="form-label">Revisor:</label>
                <select class="form-control" id="revisor" name="revisor" required>
                    <option value="">Seleccione una opción</option>
                    @foreach ($revisores as $revisor)
                        <option value="{{ $revisor->id }}">{{ $revisor->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col">
                <label for="grado" class="form-label">Total:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="total_via" name="total_via"
                        placeholder="Ingrese el total de viáticos" required>
                </div>
            </div>

        </div>


        <br><br>


        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <a href="/dashboard">
                        <button type="button" class="btn btn-outline-danger">Cancelar</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <!-- Icono SVG con clase de tamaño -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="bi me-2" width="16"
                            height="16">
                            <path
                                d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z" />
                        </svg>
                        <!-- Texto del botón -->
                        Enviar solicitud
                    </button>
                </div>
            </div>


        </div>


        <!-- Modal para mostrar el mensaje de alerta -->
        <div class="modal fade" id="periodoModal" tabindex="-1" aria-labelledby="periodoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="periodoModalLabel">Alerta de período</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="mensajePeriodo"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- Scripts de Bootstrap (jQuery primero, luego Popper.js y finalmente Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        // Inicializar Flatpickr en español
        flatpickr("#fecha_inicio", {
            dateFormat: "Y-m-d",
            locale: "es",
            onClose: function(selectedDates) {
                // Configurar la fecha mínima para la fecha de fin
                if (selectedDates.length > 0) {
                    flatpickr("#fecha_fin", {
                        minDate: selectedDates[0],
                        dateFormat: "Y-m-d",
                        locale: "es"
                    });
                }
            }
        });


        document.getElementById('proyecto').addEventListener('change', function() {
            validarPeriodo();
        });

        function validarPeriodo() {
            var proyectoSelect = document.getElementById('proyecto');
            var fechaInicioSeleccionada = new Date(document.getElementById('fecha_inicio').value);
            var fechaFinSeleccionada = new Date(document.getElementById('fecha_fin').value);

            if (proyectoSelect.value !== '') {
                var fechaInicioProyecto = new Date(proyectoSelect.options[proyectoSelect.selectedIndex].getAttribute(
                    'data-inicio'));
                var fechaFinProyecto = new Date(proyectoSelect.options[proyectoSelect.selectedIndex].getAttribute(
                    'data-fin'));

                if (fechaInicioSeleccionada.getTime() < fechaInicioProyecto.getTime() || fechaFinSeleccionada.getTime() >
    fechaFinProyecto.getTime() || fechaInicioSeleccionada.getTime() > fechaFinProyecto.getTime()) {
    // Obtener las fechas en el formato deseado
    var fechaInicioSeleccionadaFormatted = fechaInicioSeleccionada.toISOString().split('T')[0];
    var fechaFinSeleccionadaFormatted = fechaFinSeleccionada.toISOString().split('T')[0];
    var fechaInicioProyectoFormatted = fechaInicioProyecto.toISOString().split('T')[0];
    var fechaFinProyectoFormatted = fechaFinProyecto.toISOString().split('T')[0];

    var mensajeError = 'El período seleccionado (' + fechaInicioSeleccionadaFormatted + ' - ' +
        fechaFinSeleccionadaFormatted + ') ';
    mensajeError += 'debe estar dentro del rango del proyecto (' + fechaInicioProyectoFormatted +
        ' - ' + fechaFinProyectoFormatted + ').';

    // Mostrar el mensaje en el modal
    document.getElementById('mensajePeriodo').innerText = mensajeError;
    $('#periodoModal').modal('show');

    // Limpiar las fechas seleccionadas
    document.getElementById('fecha_inicio').value = "";
    document.getElementById('fecha_fin').value = "";
}

            }
        }


        document.getElementById('fecha_inicio').onchange = validarPeriodo;
        document.getElementById('fecha_fin').onchange = validarPeriodo;
    </script>
@endsection
