@extends('base')

@section('content')
    <style>
        .file-list {
            list-style: none;
            padding: 0;
        }

        .file-list-item {
            margin-bottom: 5px;
            padding: 5px;
            background-color: #f0f0f0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-list-item button {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
            padding: 3px 5px;
            border-radius: 3px;
            cursor: pointer;
            margin-left: auto;
            /* Centra el botón en medio */
        }
    </style>

    <h2 style="text-align: center">Reposición de gastos</h2>
    <br><br>
    <form class="centered-form">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre">
            </div>
            <div class="col-md-3 mb-3">
                <label for="apellido_paterno" class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno"
                    placeholder="Ingresar apellido paterno">
            </div>
            <div class="col-md-3 mb-3">
                <label for="apellido_materno" class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno"
                    placeholder="Ingresar apellido materno">
            </div>
            <div class="col-md-3 mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select class="form-select" id="sexo" name="sexo">
                    <option value="" selected>Seleccionar</option>
                    <option value="H">Hombre</option>
                    <option value="M">Mujer</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="nss" class="form-label">NSS:</label>
                <input type="text" class="form-control" id="nss" name="nss" placeholder="Ingresar NSS">
            </div>
            <div class="col-md-3 mb-3">
                <label for="curp" class="form-label">CURP:</label>
                <input type="text" class="form-control" id="curp" name="curp" placeholder="Ingresar CURP">
            </div>
            <div class="col-md-3 mb-3">
                <label for="rfc" class="form-label">RFC:</label>
                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ingresar RFC">
            </div>
            <div class="col-md-3 mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar teléfono">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresar dirección">
            </div>
            <div class="col-md-6 mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingresar correo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="departamento" class="form-label">Departamento:</label>
                <select class="form-select" id="departamento" name="departamento">
                    <option value="" selected>Seleccionar</option>
                    <option value="RRHH">RRHH</option>
                    <option value="Compras">Compras</option>
                    <option value="Sistemas">Sistemas</option>
                    <option value="Calidad">Calidad</option>
                    <option value="Ventas">Ventas</option>
                    <option value="Almacen">Almacen</option>
                    <option value="Operaciones">Operaciones</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <select class="form-select" id="puesto" name="puesto">
                    <option value="" selected>Seleccionar</option>
                    <option value="1">Gerente</option>
                    <option value="2">Supervisor</option>
                    <option value="3">Analista</option>
                    <option value="4">Asistente</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="text" class="form-control" id="fecha" name="fecha"
                    value="{{ now()->format('Y-m-d') }}" readonly>
            </div>
        </div>
        


        <br>



        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <a href="/dashboard">
                        <button type="button" class="btn btn-outline-danger">Cancelar</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <!-- Icono SVG con clase de tamaño -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="bi me-2" width="16"
                            height="16">
                            <path
                                d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z" />
                        </svg>
                        <!-- Texto del botón -->
                        Enviar comprobación
                    </button>
                </div>
            </div>

            <!-- Modal 1-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Seguro de mandar esta reposición?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalExito">Sí</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal 2-->
            <div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalExitoLabel">Mensaje de confirmación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¡Tu reposición de gasto ha sido enviada con éxito!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </form>
@endsection
