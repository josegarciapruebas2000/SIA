@extends('base')

@php
    use Carbon\Carbon;
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/flatpickr.min.css">

@section('content')
    <style>
        .upload-icon {
            cursor: pointer;
            font-size: 24px;
        }

        .uploaded {
            color: green;
        }

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
        }
    </style>

    <h2 style="text-align: center">Comprobación de gastos</h2>
    <br><br>
    <form class="centered-form">
        <div class="row mb-3">
            <div class="col">
                <label for="grupo" class="form-label">Proyecto:</label>
                <input type="text" class="form-control" id="comentario" name="proyecto"
                    placeholder="Proyecto seleccionado" value="{{ $comprobacion->proyecto->nombreProy }}" readonly>
            </div>

            <div class="col">
                <label for="grupo" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="comentario" name="cliente" placeholder="Cliente seleccionado"
                    value=" {{ $comprobacion->proyecto->cliente->nombre }}" readonly>
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
                    <input type="text" class="form-control text-center" id="inicio" name="inicio"
                        value="{{ Carbon::parse($comprobacion->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}"
                        readonly>
                </div>
                <div class="col" style="text-align: center;">
                    <label for="fecha_sesion" class="form-label">Fin:</label>
                    <input type="text" class="form-control text-center" id="inicio" name="fin"
                        value="{{ Carbon::parse($comprobacion->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}"
                        readonly>
                </div>
            </div>
        </div>

        <br><br>

        <div class="row mb-3">
            <div class="col">
                <label for="revisor" class="form-label">Revisor:</label>
                <select class="form-control" id="revisor" name="revisor" required>
                    <option value="">Seleccione una opción</option>
                    @foreach ($revisores as $revisor)
                        <option value="{{ $revisor->id }}">{{ $revisor->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col">
                <label for="tutor" class="form-label">Comentario:</label>
                <input type="text" class="form-control" id="comentario" name="comentario"
                    placeholder="Ingrese comentarios" value=" {{ $comprobacion->comentario_via }}" readonly>
            </div>
        </div>

        <br><br>

        <div class="row mb-3">
            <div class="row">
                <div class="col">
                    <!-- Campo de entrada para seleccionar archivos XML -->
                    <label class="btn btn-success d-block mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            style="fill: #ffffff; width: 1em; height: 1em;">
                            <path
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg>
                        Seleccionar XML
                        <input id="input-b3-xml" name="input-b3-xml[]" type="file" class="d-none" multiple
                            accept=".xml">
                    </label>
                    <ul id="file-list-xml" class="file-list list-group list-group-flush">
                        <!-- Aquí se agregarán las filas de la lista -->
                    </ul>
                </div>

                <style>
                    .file-list-item span {
                        overflow: hidden;
                        white-space: nowrap;
                        text-overflow: ellipsis;
                    }
                </style>



                <div class="col" style="display: none;">
                    <label class="btn btn-danger d-block mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            style="fill: #ffffff; width: 1em; height: 1em;">
                            <path
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg>
                        Seleccionar PDF
                        <input id="input-b3-pdf" name="input-b3-pdf[]" type="file" class="d-none" multiple
                            accept=".pdf">
                    </label>
                    <ul id="file-list-pdf" class="file-list"></ul>
                </div>
            </div>


        </div>

        <br><br>


        <div class="row mb-3">
            <div class="col">
                <strong><label for="tutor" class="form-label" id="monto-comprobado">Monto comprobado:
                        $0.00</label></strong>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-end mb-2 mb-sm-0">
                    <a href="{{ route('comprobaciones.lista') }}">
                        <button type="button" class="btn btn-outline-danger">Cancelar</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="d-flex justify-content-center justify-content-sm-start">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="bi me-2" width="24"
                            height="24">
                            <path fill="#ffffff"
                                d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z" />
                        </svg>
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
                            <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro que desea enviar la comprobación?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="guardar-datos">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <br>
    <div class="row mb-3">
        <div class="col-md-6 col-lg-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <input type="text" id="descripcion" class="form-control" aria-label="Descripción">
        </div>
        <div class="col-md-6 col-lg-2">
            <label for="subtotal" class="form-label">Subtotal:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" id="subtotal" class="form-control" aria-label="Subtotal">
            </div>
        </div>
        <div class="col-md-6 col-lg-2">
            <label for="iva" class="form-label">IVA:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" id="iva" class="form-control" aria-label="IVA">
            </div>
        </div>
        <div class="col-md-6 col-lg-2">
            <label for="total" class="form-label">Total:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" id="total" class="form-control" aria-label="Total" readonly>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 d-flex align-items-center justify-content-start">
            <button type="button" id="agregarManualmente" class="btn btn-primary">Agregar</button>
        </div>
    </div>



    <br>

    <div class="table-responsive">
        <table class="table table-striped rounded text-center">
            <thead>
                <tr>
                    <th scope="col">Folio</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">IVA</th>
                    <th scope="col">Total</th>
                    <th scope="col">XML</th>
                    <th scope="col">PDF</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Aquí se agregarán las filas de la tabla -->
            </tbody>
        </table>
    </div>


    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        flatpickr("#fecha_sesion", {
            dateFormat: "Y-m-d",
            locale: "es", // Establecer el idioma a español
        });

        let xmlFiles = [];
        let pdfFiles = [];

        function addFileToList(fileList, listContainer, callback, fileArray) {
            for (let i = 0; i < fileList.length; i++) {
                fileArray.push(fileList[i]);
            }
            renderFileList(listContainer, fileArray, callback);
        }

        function renderFileList(listContainer, fileArray, callback) {
            listContainer.innerHTML = '';
            fileArray.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('file-list-item');

                const fileName = document.createElement('span');
                fileName.textContent = file.name;
                listItem.appendChild(fileName);

                const removeButton = document.createElement('button');
                removeButton.textContent = 'Eliminar';
                removeButton.addEventListener('click', function() {
                    fileArray.splice(index, 1);
                    renderFileList(listContainer, fileArray, callback);
                });
                listItem.appendChild(removeButton);

                listContainer.appendChild(listItem);
            });
            callback(fileArray);
        }

        function updateMontoComprobado(files) {
            let totalAmount = 0;
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevas filas

            let fileProcessedCount = 0;
            files.forEach((file, fileIndex) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const parser = new DOMParser();
                    const xmlDoc = parser.parseFromString(event.target.result, 'text/xml');
                    const totalNodes = xmlDoc.getElementsByTagName('cfdi:Comprobante');

                    if (totalNodes.length > 0) {
                        const totalValue = parseFloat(totalNodes[0].getAttribute('Total'));
                        totalAmount += totalValue;

                        let description = '';
                        const conceptos = xmlDoc.getElementsByTagName('cfdi:Concepto');
                        for (let i = 0; i < conceptos.length; i++) {
                            const descripcion = conceptos[i].getAttribute('Descripcion');
                            if (descripcion) {
                                if (description !== '') {
                                    description += ' + ';
                                }
                                description += descripcion;
                            }
                        }

                        // Obtener el folio del XML
                        const folio = totalNodes[0].getAttribute('Folio');

                        // Crear nueva fila para cada archivo procesado
                        const row = document.createElement('tr');

                        // Crear la celda para el folio y agregarla a la fila
                        const folioCell = document.createElement('td');
                        folioCell.textContent = folio;
                        row.appendChild(folioCell);

                        // Crear celdas para los demás datos y agregarlas a la fila
                        const descriptionCell = document.createElement('td');
                        descriptionCell.textContent = description;

                        const subtotalCell = document.createElement('td');
                        subtotalCell.textContent = (totalValue / 1.16).toFixed(2); // Subtotal calculado sin IVA

                        const ivaCell = document.createElement('td');
                        const iva = totalValue - (totalValue / 1.16);
                        ivaCell.textContent = iva.toFixed(2);

                        const totalCell = document.createElement('td');
                        totalCell.textContent = totalValue.toFixed(2); // Total = subtotal + IVA

                        const xmlCell = document.createElement('td');
                        const xmlIcon = document.createElement('i');
                        xmlIcon.className =
                            'fas fa-file-alt upload-icon uploaded'; // Icono de Font Awesome con estado "cargado"
                        xmlIcon.title = file.name; // Usar el nombre del archivo como título
                        xmlCell.appendChild(xmlIcon);

                        const pdfCell = document.createElement('td');
                        const pdfInput = document.createElement('input');
                        pdfInput.type = 'file';
                        pdfInput.accept = 'application/pdf';
                        pdfInput.style.display = 'none';
                        pdfInput.dataset.fileIndex = fileIndex;
                        pdfInput.addEventListener('change', handlePdfUpload);

                        const pdfIcon = document.createElement('i');
                        pdfIcon.className = 'fas fa-upload upload-icon'; // Icono de Font Awesome
                        pdfIcon.title = 'Subir PDF';
                        pdfIcon.addEventListener('click', () => pdfInput.click());
                        pdfCell.appendChild(pdfIcon);
                        pdfCell.appendChild(pdfInput);

                        row.appendChild(descriptionCell);
                        row.appendChild(subtotalCell);
                        row.appendChild(ivaCell);
                        row.appendChild(totalCell);
                        row.appendChild(xmlCell);
                        row.appendChild(pdfCell);

                        tableBody.appendChild(row);
                    }

                    fileProcessedCount++;
                    if (fileProcessedCount === files.length) {
                        document.getElementById('monto-comprobado').textContent = 'Monto comprobado: $' +
                            totalAmount.toFixed(2);
                    }
                };
                reader.readAsText(file);
            });
        }

        function handlePdfUpload(event) {
            const fileIndex = event.target.dataset.fileIndex;
            const pdfFile = event.target.files[0];
            if (pdfFile) {
                pdfFiles[fileIndex] = pdfFile;
                const pdfIcon = event.target.previousSibling;
                pdfIcon.classList.add('uploaded');
                pdfIcon.title = pdfFile.name; // Establecer el nombre del archivo como título al pasar el cursor
            }
        }

        document.getElementById('input-b3-xml').addEventListener('change', function() {
            const fileList = document.getElementById('input-b3-xml').files;
            const listContainer = document.getElementById('file-list-xml');
            addFileToList(fileList, listContainer, updateMontoComprobado, xmlFiles);
        });

        document.getElementById('input-b3-pdf').addEventListener('change', function() {
            const fileList = document.getElementById('input-b3-pdf').files;
            const listContainer = document.getElementById('file-list-pdf');
            addFileToList(fileList, listContainer, updateMontoComprobado, pdfFiles);
        });

        function actualizarMontoComprobado(total) {
            const montoComprobadoElement = document.getElementById('monto-comprobado');
            const montoComprobadoText = montoComprobadoElement.textContent.replace('Monto comprobado: $', '').replace(',',
                '');
            const montoComprobado = parseFloat(montoComprobadoText) || 0;
            const nuevoMontoComprobado = montoComprobado + total;
            montoComprobadoElement.textContent = 'Monto comprobado: $' + nuevoMontoComprobado.toFixed(2);
        }

        document.getElementById('agregarManualmente').addEventListener('click', function() {
            // Obtener los valores ingresados por el usuario
            const descripcion = document.getElementById('descripcion').value;
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const iva = parseFloat(document.getElementById('iva').value) || 0;
            const total = subtotal + iva;

            // Comprobar si todos los campos están completos
            if (descripcion === '' || subtotal === 0 || iva === 0 || total === 0) {
                // Mostrar mensaje de advertencia con SweetAlert
                Swal.fire({
                    title: "Atención",
                    text: "Por favor, complete todos los campos correctamente.",
                    icon: "warning"
                });
                return; // Detener la ejecución si no se completan todos los campos
            }

            // Actualizar el valor del campo monto-comprobado
            actualizarMontoComprobado(total);

            // Crear una nueva fila para la tabla
            const row = document.createElement('tr');

            // Crear celdas para cada dato
            const folioCell = document.createElement('td');
            folioCell.textContent = ''; // Dejar el campo del folio en blanco para agregarlo después

            const descripcionCell = document.createElement('td');
            descripcionCell.textContent = descripcion;

            const subtotalCell = document.createElement('td');
            subtotalCell.textContent = subtotal.toFixed(2);

            const ivaCell = document.createElement('td');
            ivaCell.textContent = iva.toFixed(2);

            const totalCell = document.createElement('td');
            totalCell.textContent = total.toFixed(2);

            const xmlCell = document.createElement('td');
            const xmlIcon = document.createElement('i');
            xmlIcon.className = 'fas fa-file-alt upload-icon'; // Icono de Font Awesome
            xmlIcon.title = 'XML no cargado'; // Título predeterminado
            xmlIcon.style.color = 'red'; // Color rojo por defecto
            xmlCell.appendChild(xmlIcon);

            const pdfCell = document.createElement('td');
            const pdfInput = document.createElement('input');
            pdfInput.type = 'file';
            pdfInput.accept = 'application/pdf';
            pdfInput.style.display = 'none';
            pdfInput.addEventListener('change', handlePdfUpload);

            const pdfIcon = document.createElement('i');
            pdfIcon.className = 'fas fa-upload upload-icon'; // Icono de Font Awesome
            pdfIcon.title = 'Subir PDF';
            pdfIcon.addEventListener('click', () => pdfInput.click());
            pdfCell.appendChild(pdfIcon);
            pdfCell.appendChild(pdfInput);

            // Agregar las celdas a la fila
            row.appendChild(folioCell); // Agregar la celda del folio primero
            row.appendChild(descripcionCell);
            row.appendChild(subtotalCell);
            row.appendChild(ivaCell);
            row.appendChild(totalCell);
            row.appendChild(xmlCell);
            row.appendChild(pdfCell);

            // Agregar la fila a la tabla
            document.getElementById('table-body').appendChild(row);

            // Limpiar los campos del formulario
            document.getElementById('descripcion').value = '';
            document.getElementById('subtotal').value = '';
            document.getElementById('iva').value = '';
            document.getElementById('total').value = '';

            // Mostrar notificación de éxito
            Swal.fire({
                title: "Listo",
                text: "Se ha agregado correctamente.",
                icon: "success"
            });
        });

        function handlePdfUpload(event) {
            const fileIndex = event.target.dataset.fileIndex;
            const pdfFile = event.target.files[0];
            if (pdfFile) {
                pdfFiles[fileIndex] = pdfFile;
                const pdfIcon = event.target.previousSibling;
                pdfIcon.classList.add('uploaded');
                pdfIcon.title = pdfFile.name; // Establecer el nombre del archivo como título al pasar el cursor
            }
        }

        const subtotalInput = document.getElementById('subtotal');
        const ivaInput = document.getElementById('iva');
        const totalInput = document.getElementById('total');

        // Agregar un evento input al campo de subtotal
        subtotalInput.addEventListener('input', updateTotal);

        // Agregar un evento input al campo de iva
        ivaInput.addEventListener('input', updateTotal);

        // Función para actualizar el valor del campo total
        function updateTotal() {
            // Obtener los valores de subtotal e iva
            const subtotal = parseFloat(subtotalInput.value) || 0;
            const iva = parseFloat(ivaInput.value) || 0;

            // Calcular el total sumando subtotal y iva
            const total = subtotal + iva;

            // Actualizar el valor del campo total
            totalInput.value = total.toFixed(2);
        }


        document.getElementById('guardar-datos').addEventListener('click', function(event) {
    event.preventDefault(); // Evita el envío del formulario inmediatamente

    const nivel = document.getElementById('revisor').value;
    const montoComprobadoText = document.getElementById('monto-comprobado').textContent.replace('Monto comprobado: $', '').replace(',', '');
    const montoComprobado = parseFloat(montoComprobadoText) || 0;

    const formData = new FormData();
    const tableRows = document.querySelectorAll('#table-body tr');

    formData.append('nivel', nivel);
    formData.append('monto_comprobado', montoComprobado);

    tableRows.forEach((row, index) => {
        const cells = row.children;
        formData.append(`documentos[${index}][N_factura]`, cells[0].textContent.trim());
        formData.append(`documentos[${index}][fecha_subida]`, new Date().toISOString().slice(0, 10));
        formData.append(`documentos[${index}][descripcion]`, cells[1].textContent.trim());
        formData.append(`documentos[${index}][subtotal]`, cells[2].textContent.trim());
        formData.append(`documentos[${index}][iva]`, cells[3].textContent.trim());
        formData.append(`documentos[${index}][total]`, cells[4].textContent.trim());

        // Utilizar los arrays xmlFiles y pdfFiles para añadir los archivos al formData
        if (xmlFiles[index]) {
            formData.append(`documentos[${index}][xml]`, xmlFiles[index]);
        }
        if (pdfFiles[index]) {
            formData.append(`documentos[${index}][pdf]`, pdfFiles[index]);
        }
    });

    const id = window.location.pathname.split('/').pop(); // Obtiene el ID de la URL actual

    fetch(`/save-comprobacion/${id}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            Swal.fire({
                title: "Listo",
                text: data.message,
                icon: "success"
            }).then(() => {
                window.location.href = '/comprobaciones'; // Redirige a la lista de comprobaciones después de cerrar el modal
            });
        } else if (data.error) {
            Swal.fire({
                title: "Error",
                text: data.error,
                icon: "error"
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: "Error",
            text: 'Ocurrió un error al guardar los documentos.',
            icon: "error"
        });
    });
});

    </script>
@endsection
