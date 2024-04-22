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
            </div>
        </div>
        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-control" name="role" id="role">
                    <option value="Gerencia" {{ $usuario->role == 'Gerencia' ? 'selected' : '' }}>Gerencia</option>
                    <option value="Gerente de ventas" {{ $usuario->role == 'Gerente de ventas' ? 'selected' : '' }}>Gerente
                        de ventas</option>
                    <option value="Empleado" {{ $usuario->role == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="Contadora" {{ $usuario->role == 'Contadora' ? 'selected' : '' }}>Contadora</option>
                    <option value="Recursos Humanos" {{ $usuario->role == 'Recursos Humanos' ? 'selected' : '' }}>Recursos
                        Humanos</option>
                    <option value="SuperAdmin" {{ $usuario->role == 'SuperAdmin' ? 'selected' : '' }}>SuperAdmin</option>
                </select>
            </div>

            <div class="col">
                <label for="estado" class="form-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status"
                        value="1" {{ $usuario->status == 1 ? 'checked' : '' }} onchange="changeLabelText()">
                    <label class="form-check-label" for="flexSwitchCheckDefault" id="switchLabel">
                        {{ $usuario->status == 1 ? 'Habilitado' : 'Deshabilitado' }}
                    </label>
                </div>
            </div>


        </div>

        <br>

        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Actualizar contraseña (opcional):</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
            </div>

            <div class="col">
                <label for="confirmPassword" class="form-label">Confirmar contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese contraseña">
                <p style="font-size: 14px; color: #666;">Deje este campo en blanco para mantener la contraseña actual.</p>
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
@endsection
