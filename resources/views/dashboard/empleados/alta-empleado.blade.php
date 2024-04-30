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

        .area-container {
            display: none;
        }

        .btn-hover-purple.btn-outline-primary:hover {
            border-color: purple;
            background: purple;
            color: white;
        }

        .btn-hover-purple.btn-outline-primary {
            color: purple;
            border-color: purple;

        }
    </style>

    <h2 style="text-align: center">Alta de empleados</h2>
    <br><br>
    <form action="{{ route('add.empleado') }}" method="POST" class="centered-form">
        @csrf
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
                    <option value="H">H</option>
                    <option value="M">M</option>
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
            <div class="col-md-4 mb-3 area-container">
                <label for="area" class="form-label">Área:</label>
                <select class="form-select" id="area" name="area">
                    <option value="" selected>Seleccionar</option>
                    <option value="SEGURIDAD">SEGURIDAD</option>
                    <option value="SUPERVISOR">SUPERVISOR</option>
                    <option value="ESPECIALISTA">ESPECIALISTA</option>
                    <option value="ESPECIALIDADES">ESPECIALIDADES</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="puesto" class="form-label">Puesto:</label>
                <select class="form-select" id="puesto" name="puesto">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="text" class="form-control" id="fecha" name="fecha"
                value="{{ now()->format('Y-m-d') }}" readonly>
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
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Guardar información general
                    </button>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="d-flex justify-content-center mb-2 mb-sm-0">
                            <a href="#">
                                <button type="button" class="btn btn-outline-primary btn-hover-purple">Subir
                                    archivos</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal 1-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Recordatorio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Recuerde de cargar los archivos del empleado
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalExito">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('repositorioForm');

            form.addEventListener('submit', function(event) {
                // Obtener todos los campos del formulario
                var inputs = form.querySelectorAll('input, select');

                // Verificar si algún campo obligatorio está vacío
                var isEmpty = false;
                inputs.forEach(function(input) {
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        isEmpty = true;
                        // Agregar clase de estilo para indicar campo obligatorio vacío
                        input.classList.add('is-invalid');
                    } else {
                        // Remover clase de estilo de campo vacío
                        input.classList.remove('is-invalid');
                    }
                });

                // Detener el envío del formulario si hay campos obligatorios vacíos
                if (isEmpty) {
                    event.preventDefault();
                    alert('Por favor, completa todos los campos obligatorios.');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var departamentoSelect = document.getElementById('departamento');
            var puestoSelect = document.getElementById('puesto');
            var areaContainer = document.querySelector('.area-container');

            // Mapeo de puestos por departamento y área
            var puestosPorDepartamento = {
                'RRHH': ['Recursos humanos'],
                'Compras': ['COORDINADOR DE COMPRAS', 'AUXILIAR DE COMPRAS', 'FINANZAS', 'DPTO.LEGAL/COBRANZA'],
                'Sistemas': ['COORDINADOR DE SISTEMAS', 'CIBER SEGURIDAD'],
                'Calidad': ['COORDINADOR DE CALIDAD', 'AUXILIAR DE CALIDAD'],
                'Ventas': ['GERENTE DE VENTAS', 'DPTO. LEGAL', 'LICITACIONES/VENTAS', 'SUPERVISOR',
                    'TECNICO EN VENTAS'
                ],
                'Almacen': ['ENCARGADO DE ALMACEN'],
                'Operaciones': {
                    'GERENTE': ['GERENTE DE OPERACIONES'],
                    'SEGURIDAD': ['COORDINADOR', 'ING. DE SEGURIDAD', 'AUXILIAR DE SEGURIDAD'],
                    'SUPERVISOR': ['SUPERVISOR', 'CONTROL DE OBRA', 'TRAMITOLOGO/GESTOR'],
                    'ESPECIALISTA': ['INGENIERO TIPO B', 'INGENIERO TIPO C'],
                    'ESPECIALIDADES': ['ELECTRICO', 'CIVIL', 'MECANICO', 'DIBUJO TECNICO', 'TABLERISTA']
                }
            };

            // Event listener para cambios en el departamento
            departamentoSelect.addEventListener('change', function() {
                var departamento = this.value;

                // Limpiar opciones anteriores y añadir las nuevas según el departamento seleccionado
                puestoSelect.innerHTML = '<option value="" selected>Seleccionar</option>';
                areaContainer.style.display = 'none'; // Ocultar el campo de Área por defecto

                if (departamento === 'Operaciones') {
                    areaContainer.style.display =
                        'block'; // Mostrar el campo de Área cuando se selecciona Operaciones
                }

                if (puestosPorDepartamento[departamento]) {
                    if (Array.isArray(puestosPorDepartamento[departamento])) {
                        // Si los puestos son directamente asignados al departamento
                        puestosPorDepartamento[departamento].forEach(function(puesto) {
                            puestoSelect.innerHTML += '<option value="' + puesto + '">' + puesto +
                                '</option>';
                        });
                    } else {
                        // Si los puestos están divididos por área
                        var areaSelect = document.getElementById('area');
                        var area = areaSelect.value;

                        // Limpiar opciones anteriores y añadir las nuevas según el área seleccionada
                        areaSelect.innerHTML = '<option value="" selected>Seleccionar</option>';
                        Object.keys(puestosPorDepartamento[departamento]).forEach(function(areaKey) {
                            areaSelect.innerHTML += '<option value="' + areaKey + '">' + areaKey +
                                '</option>';
                        });
                    }
                }
            });

            // Event listener para cambios en el área (solo para el departamento de Operaciones)
            var areaSelect = document.getElementById('area');
            areaSelect.addEventListener('change', function() {
                var departamento = departamentoSelect.value;
                var area = this.value;

                // Limpiar opciones anteriores y añadir las nuevas según el área seleccionada
                puestoSelect.innerHTML = '<option value="" selected>Seleccionar</option>';
                puestosPorDepartamento[departamento][area].forEach(function(puesto) {
                    puestoSelect.innerHTML += '<option value="' + puesto + '">' + puesto +
                        '</option>';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var guardarBtn = document.querySelector('button[type="button"].btn-primary');

            guardarBtn.addEventListener('click', function(event) {
                var inputs = document.querySelectorAll('input[type="text"], input[type="email"], select');
                var isEmpty = false;

                inputs.forEach(function(input) {
                    if (!input.value.trim()) {
                        isEmpty = true;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (isEmpty) {
                    event.preventDefault();
                    alert('Por favor, completa todos los campos.');
                }
            });
        });
    </script>
@endsection
