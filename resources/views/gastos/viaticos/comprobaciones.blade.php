@extends('base')

@section('content')
    <h2 style="text-align: center">Comprobaciones de gastos</h2>
    <br><br>
    <form class="centered-form">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre de la comprobación</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Archivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Herramientas y Equipos</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>
                        <a href="/comprobacion">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px; height: 20px;">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z" />
                            </svg>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Herramientas y Equipos</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>
                        <a href="/comprobacion">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px; height: 20px;">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z" />
                            </svg>
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Herramientas y Equipos</td>
                    <td>PRY-AJEB-SALAMANCA</td>
                    <td>
                        <a href="/comprobacion">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 20px; height: 20px;">
                                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </form>
@endsection
