@extends('base')

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .error-container {
        max-width: 400px;
        margin: 100px auto;
        text-align: center;
    }

    .error-code {
        font-size: 48px;
        color: #dc3545;
    }

    .error-message {
        font-size: 24px;
        color: #343a40;
    }
</style>

@section('content')
    <div class="container error-container">
        <h1 class="error-code">Acceso prohibido</h1>
        <p class="error-message">No tienes permisos para acceder a esta página.</p>
        <!-- Puedes agregar más contenido o estilos según sea necesario mi querido bro que lea esto -->
    </div>
@endsection
