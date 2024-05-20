@extends('base')

@section('content')
    <h2 style="text-align: center">Registrar usuario</h2>
    <br><br>
    <form id="userForm" action="{{ route('guardar.usuario') }}" method="POST" class="centered-form">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Ingrese nombre de usuario" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col">
                <label for="email" class="form-label">Correo:</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Ingrese correo" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col">
                <div class="mb-3">
                    <label for="role" class="form-label">Rol:</label>
                    <select class="form-control @error('role') is-invalid @enderror" name="role">
                        <option value="">Seleccione una opción</option>
                        <option value="Calidad" {{ old('role') == 'Calidad' ? 'selected' : '' }}>Calidad</option>
                        <option value="Ciberseguridad" {{ old('role') == 'Ciberseguridad' ? 'selected' : '' }}>
                            Ciberseguridad</option>
                        <option value="Contador" {{ old('role') == 'Contador' ? 'selected' : '' }}>Contador</option>
                        <option value="Empleado" {{ old('role') == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                        <option value="Gerencia" {{ old('role') == 'Gerencia' ? 'selected' : '' }}>Gerencia</option>
                        <option value="Gerente de Ventas" {{ old('role') == 'Gerente de Ventas' ? 'selected' : '' }}>
                            Gerente de Ventas</option>
                        <option value="Gerente General" {{ old('role') == 'Gerente General' ? 'selected' : '' }}>Gerente
                            General</option>
                        <option value="Recursos Humanos" {{ old('role') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos
                            Humanos</option>
                        <option value="SuperAdmin" {{ old('role') == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                    </select>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col">
                <label for="estado" class="form-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="estado"
                        onchange="changeLabelText()">
                    <label class="form-check-label btn btn-outline-secondary btn-sm" id="switchLabel"
                        for="flexSwitchCheckDefault">Deshabilitado</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Ingrese contraseña">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col">
                <label for="confirm_password" class="form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Ingrese contraseña">
                <div id="passwordError" class="invalid-feedback" style="display: none;">
                    Las contraseñas no coinciden o no tienen al menos 8 caracteres. Por favor, inténtelo de nuevo.
                </div>
            </div>
        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="revisor" class="form-label">Revisor:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="revisorSwitch" name="revisorSwitch"
                        onchange="changeRevisorLabelText()">
                    <label class="form-check-label btn btn-outline-secondary btn-sm" id="revisorSwitchLabel"
                        for="revisorSwitch">No</label>
                </div>
            </div>

            <div class="col" id="nivelRow" style="display: none;">
                <label for="nivel" class="form-label">Nivel:</label>
                <div class="input-group mb-3">
                    <select class="form-select" id="nivel" name="nivel" aria-label="Nivel">
                        <option value="">Selecciona un nivel</option>
                        <option value="1">Nivel 1</option>
                        <option value="2">Nivel 2</option>
                        <option value="3">Nivel 3</option>
                    </select>
                    <div id="nivelError" class="invalid-feedback" style="display: none;">
                        Por favor, selecciona un nivel si activas la opción de revisor.
                    </div>
                </div>
            </div>
        </div>


        <br>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <button type="button" class="btn btn-outline-danger"
                        onclick="window.history.back()">Cancelar</button>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function validateForm() {
            var revisorSwitch = document.getElementById('revisorSwitch');
            var nivelSelect = document.getElementById('nivel');
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;
            var passwordError = document.getElementById('passwordError');

            // Reinicia los mensajes de error
            passwordError.style.display = 'none';
            document.getElementById('nivelError').style.display = 'none';

            // Validar las contraseñas
            if (password.length < 8 || password !== confirmPassword) {
                passwordError.style.display = 'block';
                return false; // Evitar que se envíe el formulario
            }

            // Si el interruptor del revisor está activado y no se ha seleccionado un nivel, muestra un mensaje de error
            if (revisorSwitch.checked && nivelSelect.value === '') {
                document.getElementById('nivelError').style.display = 'block';
                return false; // Evitar que se envíe el formulario
            }

            // Aquí puedes agregar más validaciones si las necesitas

            // Retorna true para enviar el formulario si todas las validaciones pasan
            return true;
        }



        function changeLabelText() {
            var switchLabel = document.getElementById('switchLabel');
            var switchInput = document.getElementById('flexSwitchCheckDefault');
            if (switchInput.checked) {
                switchLabel.innerText = 'Habilitado';
                switchInput.value = 1; // Si está habilitado, establece el valor en 1
            } else {
                switchLabel.innerText = 'Deshabilitado';
                switchInput.value = 0; // Si está deshabilitado, establece el valor en 0
            }
        }

        function changeRevisorLabelText() {
            var revisorSwitchLabel = document.getElementById('revisorSwitchLabel');
            var revisorSwitch = document.getElementById('revisorSwitch');
            var nivelRow = document.getElementById('nivelRow');
            if (revisorSwitch.checked) {
                revisorSwitchLabel.innerText = 'Sí';
                nivelRow.style.display = 'block';
                document.getElementById('nivel').disabled = false;
            } else {
                revisorSwitchLabel.innerText = 'No';
                nivelRow.style.display = 'none';
                document.getElementById('nivel').disabled = true;
            }
        }
    </script>
@endsection
