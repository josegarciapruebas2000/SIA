@extends('base')

@section('content')
    <h2 style="text-align: center">Editar usuario</h2>
    <br><br>
    <form class="centered-form" method="POST" action="{{ route('usuarios.update', ['id' => $usuario->id]) }}">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name"
                    placeholder="Ingrese nombre de usuario" value="{{ $usuario->name }}">
            </div>
            <div class="col">
                <label for="grado" class="form-label">Correo:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese correo"
                    value="{{ $usuario->email }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-control" name="role" id="role">
                    <option value="Calidad" {{ $usuario->role == 'Calidad' ? 'selected' : '' }}>Calidad</option>
                    <option value="Ciberseguridad" {{ $usuario->role == 'Ciberseguridad' ? 'selected' : '' }}>Ciberseguridad
                    </option>
                    <option value="Contador" {{ $usuario->role == 'Contador' ? 'selected' : '' }}>Contador</option>
                    <option value="Empleado" {{ $usuario->role == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="Gerencia" {{ $usuario->role == 'Gerencia' ? 'selected' : '' }}>Gerencia</option>
                    <option value="Gerente de Ventas" {{ $usuario->role == 'Gerente de Ventas' ? 'selected' : '' }}>Gerente
                        de ventas</option>
                    <option value="Gerente General" {{ $usuario->role == 'Gerente General' ? 'selected' : '' }}>Gerente
                        General</option>
                    <option value="Recursos Humanos" {{ $usuario->role == 'Recursos Humanos' ? 'selected' : '' }}>Recursos
                        Humanos</option>
                    <option value="SuperAdmin" {{ $usuario->role == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                </select>
            </div>
            <div class="col">
                <label for="estado" class="form-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status"
                        value="1" {{ $usuario->status == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexSwitchCheckDefault" id="switchLabel">
                        {{ $usuario->status == 1 ? 'Habilitado' : 'Deshabilitado' }}
                    </label>
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
                <label for="confirmPassword" class="form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                    placeholder="Ingrese contraseña">
                <div id="passwordError" class="invalid-feedback" style="display: none;">
                    Las contraseñas no coinciden o no tienen al menos 8 caracteres. Por favor, inténtelo de nuevo.
                </div>
            </div>
        </div>




        <div class="row mb-3">
            <div class="col">
                <label for="revisorSwitch" class="form-label">Revisor:</label>
                <div class="form-check form-switch">
                    <!-- Checkbox que enviará el valor 1 cuando esté marcado -->
                    <input class="form-check-input" type="checkbox" id="revisorSwitch" value="1" name="revisorSwitch"
                        {{ $usuario->revisor ? 'checked' : '' }}>

                    <!-- Etiqueta para mostrar el estado del checkbox -->
                    <label class="form-check-label btn btn-outline-secondary btn-sm" id="revisorSwitchLabel"
                        for="revisorSwitch">
                        {{ $usuario->revisor ? 'Sí' : 'No' }}
                    </label>
                </div>
            </div>

            <div class="col" id="nivelCol" style="{{ $usuario->revisor ? '' : 'display: none;' }}">
                <label for="nivel" class="form-label">Nivel:</label>
                <div class="input-group mb-3">
                    <select class="form-select" id="nivel" name="nivel" aria-label="Nivel">
                        <option value="">Selecciona un nivel</option>
                        <option value="1" {{ $usuario->nivel == '1' ? 'selected' : '' }}>Nivel 1</option>
                        <option value="2" {{ $usuario->nivel == '2' ? 'selected' : '' }}>Nivel 2</option>
                        <option value="3" {{ $usuario->nivel == '3' ? 'selected' : '' }}>Nivel 3</option>
                    </select>
                </div>
                <div id="nivelError" class="invalid-feedback" style="display: none;">
                    Por favor, selecciona un nivel si activas la opción de revisor.
                </div>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <a href="{{ route('usuarios.lista') }}">
                        <button type="button" class="btn btn-outline-danger">Cancelar</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="submit" class="btn btn-primary" onclick="return validateForm()">Guardar</button>
                </div>
            </div>
        </div>
    </form>



    <script>
        function validateAndSubmit() {
            if (validateForm() && validatePassword()) {
                document.getElementById("userForm").submit();
            }
        }

        function validateForm() {
            var revisorSwitch = document.getElementById('revisorSwitch');
            var nivelSelect = document.getElementById('nivel');

            // Si el interruptor del revisor está activado y no se ha seleccionado un nivel, muestra un mensaje de error
            if (revisorSwitch.checked && nivelSelect.value === '') {
                document.getElementById('nivelError').style.display = 'block';
                return false; // Evitar que se envíe el formulario
            }

            // Oculta el mensaje de error si se selecciona un nivel
            document.getElementById('nivelError').style.display = 'none';

            // Aquí puedes agregar más validaciones si las necesitas

            // Retorna true si todas las validaciones son exitosas
            return true;
        }

        // Obtener los elementos de contraseña y confirmación de contraseña
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordError = document.getElementById('passwordError');

        // Agregar un evento de entrada a los campos de contraseña y confirmación de contraseña
        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);

        // Función para validar las contraseñas
        function validatePassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword || password.length < 8) {
                passwordError.style.display = 'block'; // Mostrar el mensaje de error
                return false; // Las contraseñas no coinciden o no tienen al menos 8 caracteres
            } else {
                passwordError.style.display = 'none'; // Ocultar el mensaje de error si las contraseñas coinciden
                return true; // Las contraseñas coinciden
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



        // Obten el interruptor de revisor y el campo de nivel
        var revisorSwitch = document.getElementById('revisorSwitch');
        var nivelCol = document.getElementById('nivelCol');

        // Agrega un evento de cambio al interruptor de revisor
        revisorSwitch.addEventListener('change', function() {
            // Si el interruptor está marcado, muestra el campo de nivel; de lo contrario, ocúltalo
            if (revisorSwitch.checked) {
                nivelCol.style.display = '';
            } else {
                nivelCol.style.display = 'none';
                // También puedes limpiar el valor seleccionado del campo de nivel
                document.getElementById('nivel').value = '';
            }
        });
    </script>
@endsection
