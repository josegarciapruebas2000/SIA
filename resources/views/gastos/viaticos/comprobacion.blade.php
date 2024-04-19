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
        margin-left: auto; /* Centra el botón en medio */
    }
</style>

<h2 style="text-align: center">Comprobación de gastos</h2>
<br><br>
<form class="centered-form">
    <div class="row mb-3">
        <div class="col">
            <label for="grupo" class="form-label">Proyecto:</label>
            <input type="text" class="form-control" id="comentario" name="proyecto" placeholder="Proyecto seleccionado"
                readonly>
        </div>

        <div class="col">
            <label for="grupo" class="form-label">Cliente:</label>
            <input type="text" class="form-control" id="comentario" name="cliente" placeholder="Cliente seleccionado"
                readonly>

        </div>

    </div>
    <br>
    <br>

    <div class="col">
        <div class="row mb-3">
            <div class="col text-center">
                <label for="generacion" class="form-label">Periodo:</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col" style="text-align: center;">
                <label for="fecha_sesion" class="form-label">Inicio:</label>
                <input type="text" class="form-control" id="inicio" name="inicio" readonly>
            </div>
            <div class="col" style="text-align: center;">
                <label for="fecha_sesion" class="form-label">Fin:</label>
                <input type="text" class="form-control" id="inicio" name="fin" readonly>
            </div>
        </div>
    </div>

    <br><br>

    <div class="row mb-3">



        <div class="col">
            <label for="grado" class="form-label">Revisor:</label>
            <select class="form-control">
                <option>Seleccione una opción</option>
                <option>Revisor 1</option>
                <option>Revisor 2</option>
                <option>Revisor 3</option>
            </select>

        </div>
    </div>

    <br><br>

    <div class="row mb-3">
        <div class="row">
            <div class="col">
                <label class="btn btn-success d-block mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="fill: #ffffff; width: 1em; height: 1em;">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                    </svg>
                    Seleccionar XML
                    <input id="input-b3-xml" name="input-b3-xml[]" type="file" class="d-none" multiple accept=".xml">
                </label>
                <ul id="file-list-xml" class="file-list"></ul>
            </div>
            <div class="col">
                <label class="btn btn-danger d-block mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="fill: #ffffff; width: 1em; height: 1em;">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                    </svg>
                    Seleccionar PDF
                    <input id="input-b3-pdf" name="input-b3-pdf[]" type="file" class="d-none" multiple accept=".pdf">
                </label>
                <ul id="file-list-pdf" class="file-list"></ul>
            </div>
        </div>
        
        <script>
            function addFileToList(fileList, listContainer) {
                listContainer.innerHTML = '';
                for (var i = 0; i < fileList.length; i++) {
                    var listItem = document.createElement('li');
                    listItem.classList.add('file-list-item');

                    var fileName = document.createElement('span');
                    fileName.textContent = fileList[i].name;
                    listItem.appendChild(fileName);

                    var removeButton = document.createElement('button');
                    removeButton.textContent = 'Eliminar';
                    removeButton.addEventListener('click', function() {
                        listItem.remove();
                    });
                    listItem.appendChild(removeButton);

                    listContainer.appendChild(listItem);
                }
            }

            document.getElementById('input-b3-xml').addEventListener('change', function() {
                var fileList = document.getElementById('input-b3-xml').files;
                var listContainer = document.getElementById('file-list-xml');
                addFileToList(fileList, listContainer);
            });

            document.getElementById('input-b3-pdf').addEventListener('change', function() {
                var fileList = document.getElementById('input-b3-pdf').files;
                var listContainer = document.getElementById('file-list-pdf');
                addFileToList(fileList, listContainer);
            });
        </script>

    </div>

    <br><br>

    <div class="row mb-3">
        <div class="col">
            <label for="tutor" class="form-label">Comentario:</label>
            <input type="text" class="form-control" id="comentario" name="comentario"
                placeholder="Ingrese comentarios">
        </div>
        <div class="col">
            <label for="grado" class="form-label">Total:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
            </div>
        </div>

    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="tutor" class="form-label">Monto comprobado: _ _ _ _ _ _ _ _</label>
        </div>
        <div class="col">
            <label for="grado" class="form-label">Monto a comprobar: _ _ _ _ _ _ _ _</label>
        </div>

    </div>


    <br><br>


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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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

        <!-- Modal -->
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
                        ¡Tu comprobación de gasto ha sido enviada con éxito!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
    // Inicializar Flatpickr en español
    flatpickr("#fecha_sesion", {
        dateFormat: "Y-m-d",
        locale: "es", // Establecer el idioma a español
    });
</script>
@endsection
