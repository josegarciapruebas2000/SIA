<!DOCTYPE html>
<html lang="es">

@php
    use Carbon\Carbon;
@endphp

<link rel="icon" href="/img/logo.png" sizes="32x32" type="image/png">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOLICITUD DE COMPROBACION DE GASTOS</title>
    <style>
        .print-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .print-button:hover {
            background-color: #0056b3;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .print-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        }

        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
            }

            footer,
            header,
            .hide-on-print,
            .print-button {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 60px auto; /* Ajusta este valor para mover más abajo */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            margin-top: 60px; /* Agrega un margen superior a la tabla */
        }

        .header-table th,
        .header-table td {
            padding: 8px;
            text-align: center;
        }

        .header-table .logo img {
            width: 100px;
            display: block;
            margin: auto;
        }

        .header-table .title h4 {
            margin: 0;
            font-size: 1.2em;
        }

        .header-table .revision p {
            margin: 0;
            font-size: 0.9em;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fafafa;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature-table td {
            padding-top: 50px;
        }

        .gastos-realizados-table th,
        .gastos-realizados-table td {
            text-align: center;
        }

        .signature-table th,
        .signature-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .signature-table .sign-space {
            height: 90px;
        }

        .signature-table .sign-space td {
            vertical-align: bottom;
            font-size: 12px;
            font-style: italic;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            body {
                width: 100%;
                height: 100vh;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .container {
                box-shadow: none;
                margin: 0;
                width: auto;
                max-width: 100%;
            }

            footer,
            header,
            .hide-on-print,
            button {
                display: none;
            }

            .form-control {
                display: none;
            }

            .print-text {
                display: block !important;
            }

            .cuenta-bancaria {
                display: none;
            }

            .print-text-banca {
                display: block !important;
            }
        }

        .print-text {
            display: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .header-table,
        .gastos-realizados-table,
        .signature-table {
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature-table .sign-space {
            height: 90px;
            vertical-align: bottom;
            font-size: 12px;
            font-style: italic;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="container">
        <table class="header-table">
            <tr>
                <td class="logo"><img src="/img/logo.png" alt="Logo"></td>
                <td class="title">
                    <h4>SOLICITUD DE COMPROBACIÓN DE GASTOS</h4>
                </td>
                <td class="revision">
                    <p id="revision-data">Rev: 0<br>Fecha: <span id="current-date"></span><br>Página: <span
                            id="current-page"></span> de <span id="total-pages"></span></p>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Fecha de solicitud:</th>
                <td>{{ Carbon::parse($comprobacion->solicitudviatico->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}
                </td>
                <th>Periodo del gasto:</th>
                <th>Del</th>
                <td>{{ Carbon::parse($comprobacion->solicitudviatico->proyecto->fechaInicio)->translatedFormat('d \\ F \\ Y') }}
                </td>
            </tr>
            <tr>
                <th>Fecha de requerido:</th>
                <td>{{ Carbon::parse($comprobacion->solicitudviatico->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}
                </td>
                <td></td>
                <th>Al</th>
                <td>{{ Carbon::parse($comprobacion->solicitudviatico->proyecto->fechaFin)->translatedFormat('d \\ F \\ Y') }}
                </td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <th>A nombre de (Beneficiario):</th>
                <td colspan="5">{{ $comprobacion->solicitudviatico->user->name }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Se solicita la cantidad de:</th>
                <td>$ <span id="total-amount">{{ number_format($comprobacion->solicitudviatico->total_via, 2) }}</span>
                </td>
                <th>como</th>
                <td>Comprobación</td>
            </tr>
            <tr>
                <th>Cantidad con letra:</th>
                <td colspan="5"><span id="amount-in-words">Cero</span></td>
            </tr>
            <tr>
                <th>Concepto o motivo del gasto:</th>
                <td colspan="5">{{ $comprobacion->solicitudviatico->nombreSolicitud }}</td>
            </tr>
        </table>

        <h3>GASTOS REALIZADOS</h3>
        <table class="gastos-realizados-table">
            <tr>
                <th colspan="1">Código QB</th>
                <td style="text-align: left;" colspan="4"></td>
            </tr>
            <tr>
                <th>Factura</th>
                <th>Descripción</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
            @foreach ($comprobacion->documentos as $documento)
                <tr>
                    <td>{{ $documento->N_factura }}</td>
                    <td>{{ $documento->descripcion }}</td>
                    <td>{{ number_format($documento->subtotal, 2) }}</td>
                    <td>{{ number_format($documento->iva, 2) }}</td>
                    <td>{{ number_format($documento->total, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="right bold" style="text-align: right;">Totales:</td>
                <td class="bold">{{ number_format($totalSubtotal, 2) }}</td>
                <td class="bold">{{ number_format($totalIva, 2) }}</td>
                <td class="bold">{{ number_format($totalTotal, 2) }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th class="right bold">Subtotal</th>
                <td>$ {{ number_format($totalSubtotal, 2) }}</td>
            </tr>
            <tr>
                <th class="right bold">IVA</th>
                <td>$ {{ number_format($totalIva, 2) }}</td>
            </tr>
            <tr>
                <th class="right bold">Total Comprobado</th>
                <td>$ {{ number_format($totalComprobado, 2) }}</td>
            </tr>
            <tr>
                <th class="right bold">Total a Comprobar</th>
                <td>$ {{ number_format($totalAComprobar, 2) }}</td>
            </tr>
            <tr>
                <th class="right bold">Diferencia</th>
                <td class="bold">$ {{ number_format($diferencia, 2) }}</td>
            </tr>
            <tr>
                <th class="right bold">A favor</th>
                <td class="bold">{{ $aFavor }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Departamento:</th>
                <td>
                    <p class="no-bold">
                        <input type="text" class="form-control" placeholder="Ingrese un departamento">
                        <span class="print-text"></span>
                    </p>
                </td>
                <th>Proyecto (Quickbooks):</th>
                <td>{{ $comprobacion->solicitudviatico->nombreSolicitud }}</td>
            </tr>
            <tr>
                <td colspan="4" class="center bold underline">Si requiere transferencia electrónica, favor de llenar
                    los siguientes datos</td>
            </tr>
            <tr>
                <th class="center">Cuenta Bancaria</th>
                <td colspan="3" class="center">
                    <p class="no-bold">
                        <input type="text" class="cuenta-bancaria" placeholder="Ingrese cuenta bancaria">
                        <span class="print-text-banca"></span>
                    </p>
                </td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <th>SOLICITA</th>
                <th>AUTORIZA</th>
                <th>REVISA</th>
            </tr>
            <tr class="sign-space">
                <td>{{ $comprobacion->solicitudviatico->user->name }}</td>
                <td>{{ $user->name }}</td>
                <td></td>
            </tr>
            <tr>
                <td>Nombre y Firma</td>
                <td>Nombre y Firma</td>
                <td>Nombre y Firma</td>
            </tr>
        </table>
    </div>

    <button class="print-button" onclick="prepareForPrint()">Vista Previa / Imprimir</button>

    <script>
        function prepareForPrint() {
            // Para el campo de texto general
            var generalInput = document.querySelector('.form-control');
            var generalSpan = document.querySelector('.print-text');
            generalSpan.textContent = generalInput.value;

            // Para el campo de cuenta bancaria
            var cuentaInput = document.querySelector('.cuenta-bancaria');
            var cuentaSpan = document.querySelector('.print-text-banca');
            if (cuentaInput.value.trim() === "") {
                cuentaSpan.textContent = "N/D (N/D: N/D)";
            } else {
                cuentaSpan.textContent = cuentaInput.value;
            }

            window.print();
        }

        function updateDateAndPagination() {
            const currentDate = new Date();
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            document.getElementById('current-date').textContent = currentDate.toLocaleDateString('es-ES', options);

            document.getElementById('current-page').textContent = '1';
            document.getElementById('total-pages').textContent = '1';
        }

        window.onload = updateDateAndPagination;

        function numberToWords(num) {
            const units = ['Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez',
                'Once', 'Doce', 'Trece', 'Catorce', 'Quince'
            ];
            const tens = ['', '', 'Veinte', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'];
            const hundreds = ['', 'Cien', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos',
                'Setecientos', 'Ochocientos', 'Novecientos'
            ];

            function convertToWords(n) {
                if (n < 16) return units[n];
                if (n < 20) return 'Dieci' + units[n - 10].toLowerCase();
                if (n < 30) return (n === 20) ? 'Veinte' : 'Veinti' + units[n - 20].toLowerCase();
                if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 === 0 ? '' : ' y ' + units[n % 10].toLowerCase());
                if (n < 200) return (n === 100 ? 'Cien' : 'Ciento ' + convertToWords(n - 100).toLowerCase());
                if (n < 1000) return hundreds[Math.floor(n / 100)] + ' ' + convertToWords(n % 100).toLowerCase();
                if (n === 1000) return 'Mil';
                if (n < 2000) return 'Mil ' + convertToWords(n % 1000).toLowerCase();
                if (n < 1000000) return convertToWords(Math.floor(n / 1000)) + ' mil' + (n % 1000 !== 0 ? ' ' +
                    convertToWords(n % 1000).toLowerCase() : '');

                return n.toString();
            }

            return convertToWords(num);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const totalAmount = parseFloat(document.getElementById('total-amount').textContent);
            const integerPart = Math.floor(totalAmount);
            const decimalPart = Math.round((totalAmount - integerPart) * 100);

            const amountInWords = numberToWords(integerPart);
            const formattedAmount = amountInWords.charAt(0).toUpperCase() + amountInWords.slice(1) +
                ` pesos ${decimalPart.toString().padStart(2, '0')}/100 M.N.`;

            document.getElementById('amount-in-words').textContent = formattedAmount;
        });
    </script>

</body>

</html>
