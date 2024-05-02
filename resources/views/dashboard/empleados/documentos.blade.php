@extends('base')

@section('content')
    <h2 class="text-center">Documentos de {{ $empleadoNombre->nombre_Emp }}</h2>
    <br><br>
    <form action="{{ route('documentos.empleado.guardar', ['id' => $empleado->id_Emp]) }}" method="POST" class="centered-form"
        id="repositorioForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="mb-5">
                    <label for="solicitud_empleo" class="form-label"><strong>Solicitud de empleo:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="solicitud_empleo" name="solicitud_empleo">
                    </div>
                    @if ($docsEmpleado->solicitud_empleo)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'solicitud_empleo']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar solicitud de empleo</a>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-5">
                    <label for="constancia_fiscal" class="form-label"><strong>Constancia de situación
                            fiscal:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="constancia_fiscal" name="constancia_fiscal">
                    </div>
                    @if ($docsEmpleado->constancia_fiscal)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'constancia_fiscal']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar constancia de situación fiscal</a>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-5">
                    <label for="titulo_universidad" class="form-label"><strong>Título de universidad:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="titulo_universidad" name="titulo_universidad">
                    </div>
                    @if ($docsEmpleado->titulo_universidad)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'titulo_universidad']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar título de universidad</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="ine" class="form-label"><strong>INE:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="ine" name="ine">
                    </div>
                    @if ($docsEmpleado->ine)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'ine']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar INE</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="comprobante_domicilio" class="form-label"><strong>Comprobante de domicilio:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="comprobante_domicilio" name="comprobante_domicilio">
                    </div>
                    @if ($docsEmpleado->comprobante_domicilio)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'comprobante_domicilio']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar Comprobante de domicilio</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="cedula" class="form-label"><strong>Cédula:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="cedula" name="cedula">
                    </div>
                    @if ($docsEmpleado->cedula)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'cedula']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar Cédula</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="curp" class="form-label"><strong>CURP:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="curp" name="curp">
                    </div>
                    @if ($docsEmpleado->curp)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'curp']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar CURP</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="nss" class="form-label"><strong>NSS:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="nss" name="nss">
                    </div>
                    @if ($docsEmpleado->nss)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'nss']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar NSS</a>
                    @endif
                </div>
            </div>


            <div class="col-md-4">
                <div class="mb-5">
                    <label for="comprobatorio_experiencia" class="form-label"><strong>Comprobatorio de
                            experiencia:</strong></label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="comprobatorio_experiencia"
                            name="comprobatorio_experiencia">
                    </div>
                    @if ($docsEmpleado->comprobatorio_experiencia)
                        <div class="text-muted mt-2">Documento cargado</div>
                        <a href="{{ route('documentos.empleado.descargar', ['id' => $empleado->id_Emp, 'tipo' => 'comprobatorio_experiencia']) }}"
                            class="btn btn-outline-secondary mt-2">Descargar Comprobatorio de experiencia</a>
                    @endif
                </div>
            </div>


            <br><br>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('empleados.lista') }}">
                            <button type="button" class="btn btn-outline-secondary me-md-2">Regresar</button>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="submit" class="btn btn-primary">Guardar documentos</button>
                    </div>
                </div>
            </div>
    </form>
@endsection
