@extends('base')

@section('content')
    <h2 style="text-align: center">Añadir de usuario</h2>
    <br><br>
    <form class="centered-form">
        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre de usuario"
                    oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="col">
                <label for="grado" class="form-label">Correo:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese correo"
                    oninput="this.value = this.value.toUpperCase()">
            </div>

        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Rol:</label>
                <select class="form-control">
                    <option>Seleccione una opción</option>
                    <option>Ventas</option>
                    <option>Empleado</option>
                    <option>Contador</option>
                    <option>Almacen</option>
                    <option>SuperAdmin</option>
                </select>
            </div>

            <div class="col">
                <label for="grado" class="form-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                        onchange="changeLabelText()">
                    <label class="form-check-label" id="switchLabel" for="flexSwitchCheckDefault">Deshabilitado</label>
                </div>
            </div>

            <script>
                function changeLabelText() {
                    var switchLabel = document.getElementById('switchLabel');
                    var switchInput = document.getElementById('flexSwitchCheckDefault');

                    if (switchInput.checked) {
                        switchLabel.innerText = 'Habilitado';
                    } else {
                        switchLabel.innerText = 'Deshabilitado';
                    }
                }
            </script>

        </div>

        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="grado" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
            </div>

            <div class="col">
                <label for="grado" class="form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña"
                    oninput="this.value = this.value.toUpperCase()">
            </div>
        </div>

        <br><br>


        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <button type="button" class="btn btn-outline-danger" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Guardar
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¡Se ha creado el nuevo usuario con éxito!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
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
