@extends('base')

@section('content')
    <h2 style="text-align: center">Información de usuario</h2>
    <br><br>
    <form class="centered-form" method="POST" action="{{ route('perfil.actualizar') }}">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre de usuario"
                    value="{{ auth()->user()->name }}">
            </div>
            <div class="col">
                <label for="email" class="form-label">Correo:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese correo"
                    value="{{ auth()->user()->email }}">
            </div>
        </div>
        
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Actualizar contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
            </div>
        
            <div class="col">
                <label for="password_confirmation" class="form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme contraseña">
                <div id="passwordError" class="invalid-feedback" style="display: none;">
                    Las contraseñas no coinciden o no tienen al menos 8 caracteres. Por favor, inténtelo de nuevo.
                </div>
            </div>
        </div>
        <br>

        <!-- Leyenda para cerrar sesión -->
        <div class="row">
            <div class="col">
                <p style="font-size: 14px; color: #666; text-align: center;">Al guardar, la sesión se cerrará automáticamente para aplicar cambios.</p>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <button type="button" class="btn btn-outline-danger" onclick="window.history.back()">Cancelar</button>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary" onclick="return validatePassword()">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const passwordError = document.getElementById('passwordError');

            // Verificar si los campos de contraseña no están vacíos
            if (password !== '' && confirmPassword !== '') {
                if (password.length < 8 || password !== confirmPassword) {
                    passwordError.style.display = 'block';
                    return false; // Evitar que se envíe el formulario
                } else {
                    passwordError.style.display = 'none';
                    return true; // Permitir el envío del formulario
                }
            } else {
                return true; // Permitir el envío del formulario si los campos de contraseña están vacíos
            }
        }
    </script>

@endsection
