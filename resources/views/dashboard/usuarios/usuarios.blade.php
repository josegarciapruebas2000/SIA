@extends('base')

@section('content')
    <h2 style="text-align: center">Usuarios</h2>
    <br><br>

    <div class="row mb-3 justify-content-end">
        <div class="col-auto">
            <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <div class="col-auto">
            <a href="{{ route('registrar.usuario') }}">
                <button type="button" class="btn btn-primary btn-sm mb-2 mb-sm-0">Agregar</button>
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('dashboard') }}">
                <button type="button" class="btn btn-outline-secondary btn-sm mb-2 mb-sm-0">Regresar</button>
            </a>
        </div>
    </div>

    <br>
    <form class="centered-form">
        <!-- Mostrar la alerta solo si hay un mensaje de éxito -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <!-- Cuerpo de la tabla -->
            <table class="table table-striped">
                <!-- Encabezado de la tabla -->
                <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Nombre</th>
                        <th scope="col" class="text-center">Correo</th>
                        <th scope="col" class="text-center">Rol</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Iteración sobre los usuarios -->
                    @foreach ($users as $user)
                        <tr class="{{ $user->status ? '' : 'table-danger' }} align-middle">
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->role }}</td>
                            <td class="text-center">{{ $user->status ? 'Habilitado' : 'Deshabilitado' }}</td>
                            <td class="text-center"> 
                                <!-- Botones de acción -->
                                <div class="button-container d-flex justify-content-center justify-content-sm-end">
                                    @if ($user->status)
                                        <button type="button" class="btn btn-outline-secondary btn-sm mx-1" onclick="toggleUsuario({{ $user->id }})">Deshabilitar</button>
                                    @else
                                        <button type="button" class="btn btn-outline-success btn-sm mx-1" onclick="toggleUsuario({{ $user->id }})">Habilitar</button>
                                    @endif
                                    <a href="{{ route('editar.usuario', ['id' => $user->id]) }}" style="text-decoration: none;">
                                        <button type="button" class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                    </a>                                                                       
                                    <form method="POST" action="{{ route('usuarios.delete', ['id' => $user->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm mx-1">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    <style>
        /* Estilos adicionales aquí */
    </style>

<!-- Paginación -->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item">
        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only"></span>
        </a>
      </li>
      @for ($i = 1; $i <= $users->lastPage(); $i++)
        <li class="page-item {{ ($users->currentPage() == $i) ? 'active' : '' }}">
          <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
        </li>
      @endfor
      <li class="page-item">
        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only"></span>
        </a>
      </li>
    </ul>
  </nav>
      
    <!-- Script para ocultar la alerta después de 3 segundos -->
    <script>
        // Ocultar la alerta después de 3 segundos
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);
    </script>

    <script>
        
    function toggleUsuario(userId) {
        fetch("{{ url('usuarios') }}/" + userId + "/toggle", {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                // Actualizar la página después de la solicitud exitosa
                window.location.reload();
            } else {
                // Manejar errores en la solicitud
                console.error('Error al procesar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

@endsection
