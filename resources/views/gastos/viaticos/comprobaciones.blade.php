@extends('base')

@section('content')
    <h2 style="text-align: center">Comprobaciones de gastos</h2>
    <br><br>
    <form class="centered-form">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Nombre de la comprobación</th>
                        <th scope="col">Beneficiario</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($comprobaciones->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">No hay datos disponibles</td>
                        </tr>
                    @else
                        @foreach ($comprobaciones as $comprobacion)
                            <tr>
                                <td scope="row">{{ $comprobacion->FOLIO_via }}</td>
                                <td>{{ $comprobacion->nombreSolicitud }}</td>
                                <td>{{ $comprobacion->user->name }}</td>
                                <td>{{ $comprobacion->proyecto->cliente->nombre }}</td>
                                <!-- Ajustar si el nombre del proyecto está en una relación -->
                                <td>
                                    <a href="{{ route('ver.comprobacion', ['id' => $comprobacion->FOLIO_via]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                            style="width: 20px; height: 20px;">
                                            <path
                                                d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


    </form>
@endsection
