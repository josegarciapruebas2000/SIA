@extends('base')

@section('content')
    <h2 style="text-align: center">Usuarios</h2>
    <br><br>

    <div class="row mb-3 justify-content-end">
        <div class="col-auto">
            <input type="text" class="form-control" placeholder="Buscar">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary">Agregar</button>
        </div>
    </div>


    <br>
    <form class="centered-form">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>
              @foreach($users as $user)
                  <tr @if(!$user->status) class="table-danger" @endif>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role }}</td>
                      <td>{{ $user->status ? 'Habilitado' : 'Deshabilitado' }}</td>
                      <td>
                          @if($user->status)
                              <button type="button" class="btn btn-outline-secondary">Deshabilitar</button>
                          @else
                              <button type="button" class="btn btn-outline-success">Habilitar</button>
                          @endif
                          <a href="/profile" style="text-decoration: none;">
                              <button type="button" class="btn btn-outline-warning">Editar</button>
                          </a>
                          <button type="button" class="btn btn-outline-danger">Eliminar</button>
                      </td>
                  </tr>
              @endforeach
          </tbody>
          
        </table>
    </form>

    <div class="pagination justify-content-end">
      {{ $users->links() }}
  </div>
@endsection
