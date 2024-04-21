@extends('base')

@section('content')
    <h2 style="text-align: center">Registrar usuario</h2>
    <br><br>
    <form id="userForm" action="{{ route('guardar.usuario') }}" method="POST" class="centered-form">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name"
                    placeholder="Ingrese nombre de usuario">
            </div>
            <div class="col">
                <label for="email" class="form-label">Correo:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese correo">
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col">
                <label for="role" class="form-label">Rol:</label>
                <select class="form-control" name="role">
                    <option>Seleccione una opción</option>
                    <option value="Gerencia">Gerencia</option>                    
                    <option value="Gerente de ventas">Gerente de ventas</option>
                    <option value="Empleado">Empleado</option>
                    <option value="Contadora">Contadora</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                    <option value="Superadmin">SuperAdmin</option>
                </select>
            </div>
            <div class="col">
                <label for="estado" class="form-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="estado"
                        onchange="changeLabelText()">
                    <label class="form-check-label" id="switchLabel" for="flexSwitchCheckDefault">Deshabilitado</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
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
        <br><br>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <button type="button" class="btn btn-outline-danger" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary" onclick="return validatePassword()">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
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

        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('passwordError');

            if (password.length < 8 || password !== confirmPassword) {
                passwordError.style.display = 'block';
                return false; // Evitar que se envíe el formulario
            } else {
                passwordError.style.display = 'none';
                return true; // Permitir el envío del formulario
            }
        }
    </script>
@endsection
