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
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Ingrese correo" value="{{ old('email') }}">
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
                <label for="role" class="form-label">Rol:</label>
                <select class="form-control @error('role') is-invalid @enderror" name="role">
                    <option value="">Seleccione una opción</option>
                    <option value="Gerencia" {{ old('role') == 'Gerencia' ? 'selected' : '' }}>Gerencia</option>                    
                    <option value="Gerente de ventas" {{ old('role') == 'Gerente de ventas' ? 'selected' : '' }}>Gerente de ventas</option>
                    <option value="Empleado" {{ old('role') == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="Contadora" {{ old('role') == 'Contadora' ? 'selected' : '' }}>Contador</option>
                    <option value="Recursos Humanos" {{ old('role') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                    <option value="SuperAdmin" {{ old('role') == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                </select>
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
                    <label class="form-check-label btn btn-outline-secondary btn-sm" id="switchLabel" for="flexSwitchCheckDefault">Deshabilitado</label>
                </div>
            </div>
        </div>
        <br>
        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Ingrese contraseña">
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
