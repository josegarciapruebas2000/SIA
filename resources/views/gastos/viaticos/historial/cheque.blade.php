<!DOCTYPE html>
<html lang="es">

@php
    use Carbon\Carbon;
@endphp


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOLICITUD DE CHEQUE ELETRONICO</title>
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
            .hide-on-print {
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
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
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
            /* Alinea el contenido al fondo de la celda */
            font-size: 12px;
            /* Ajusta el tamaño del texto si es necesario */
            font-style: italic;
            /* Opcional: estilo de fuente para diferenciarlo */
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
                /* Altura completa de la ventana de visualización */
                margin: 0;
                display: flex;
                /* Habilita Flexbox para el body */
                justify-content: center;
                /* Centrado horizontal */
                align-items: center;
                /* Centrado vertical */
                padding: 0;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .container {
                box-shadow: none;
                margin: 0;
                width: auto;
                max-width: 100%;
                /* Ancho máximo para evitar desbordamiento */
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
            /* Altura mínima completa de la ventana de visualización */
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            /* Margen para mantener el contenido centrado y dentro de un marco visual atractivo */
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


        .no-bold {
            font-weight: normal;
            /* Quitar negrita del texto */
        }
    </style>

    </style>
</head>

<body>

    <div class="container">
        <table class="header-table">
            <tr>
                <td class="logo"><img src="/img/logo.png" alt="Logo"></td>
                <td class="title">
                    <h4>SOLICITUD DE CHEQUE ELETRÓNICO</h4>
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
                <td>{{ Carbon::parse($solicitud->solicitudfecha_via)->translatedFormat('d \\ F \\ Y') }}</td>
                <th>Fecha de requerido:</th>
                <td colspan="4">{{ Carbon::parse($solicitud->solFinalFecha_via)->translatedFormat('d \\ F \\ Y') }}</td>
            </tr>
            <tr>
                <th>Se solicita la cantidad de:</th>
                <td colspan="4">$ <span id="total-amount">{{ $solicitud->total_via }}</span></td>
            </tr>
            <tr>
                <th>Cantidad con letra:</th>
                <td colspan="5"><span id="amount-in-words">Cero</span></td>
            </tr>
            <tr>
                <th>A nombre de (Beneficiario):</th>
                <td colspan="5">{{ $solicitud->user->name }}</td>
            </tr>
            <tr>
                <th>Concepto o motivo:</th>
                <td colspan="5">{{ $solicitud->nombreSolicitud }}</td>
            </tr>
        </table>

        <h3>PRESUPUESTO</h3>
        <table class="gastos-realizados-table">
            <tr>
                <th>Código QB</th>
                <td style="text-align: left;" colspan="3"></td>
            </tr>
            <tr>
                <th rowspan="2">Concepto</th>
                <td style="text-align: left;" colspan="5">{{ $solicitud->nombreSolicitud }}</td>

            </tr>
            <tr>
                <th>Subtotal</th>
                <th style="text-align: left;">IVA</th>
            </tr>
            <tr>
                <td></td>
                <td class="bold">$ {{ $solicitud->total_via }}</td>
                <td style="text-align: left;" class="bold">$ 0.00</td>
            </tr>
            <tr>
                <th colspan="2" class="bold" style="text-align: right;">Total</th>
                <td style="text-align: left;" class="bold">$ {{ $solicitud->total_via }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Número de personas:</th>
                <th colspan="4">Perido del gasto:</th>
            </tr>
            <tr>
                <td>1</td>
                <th>Del</th>
                <td>{{ Carbon::parse($solicitud->proyecto->fechaInicio)->translatedFormat('d \\ F \\ Y') }}</td>
                <th>Al</th>
                <td>{{ Carbon::parse($solicitud->proyecto->fechaFin)->translatedFormat('d \\ F \\ Y') }}</td>
            </tr>
            <tr>
                <th>Departamento <br>
                    <p class="no-bold">
                        <input type="text" class="form-control">
                        <span class="print-text"></span>
                    </p>
                </th>
                <th colspan="4">Nombre del proyecto <br>
                    <p class="no-bold">{{ $solicitud->proyecto->nombreProy }}</p>
                </th>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <th>SOLICITA</th>
                <th>AUTORIZA</th>
                <th>VO. BO.</th>
            </tr>
            <tr class="sign-space">
                <td>{{ $solicitud->user->name }}</td>
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
            var input = document.querySelector('.form-control');
            var span = document.querySelector('.print-text');
            span.textContent = input.value;
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

            // Establecer la paginación (asumiendo que el documento se maneja en una sola página para este ejemplo)
            document.getElementById('current-page').textContent = '1';
            document.getElementById('total-pages').textContent = '1'; // Cambiar según la cantidad de páginas real
        }

        window.onload = updateDateAndPagination; // Asegura que la función se ejecuta después de cargar el documento

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
