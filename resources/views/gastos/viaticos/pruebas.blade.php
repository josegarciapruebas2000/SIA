<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Comprobación de Gastos</title>
    <style>
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
            body {
                font-size: 12px;
                background-color: #fff;
            }

            .container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 20px;
                width: 100%;
                max-width: 100%;
                background-color: #fff;
                margin-left: -20px;
                /* Ajustar margen izquierdo */
                margin-right: 0;
                /* Ajustar margen derecho */
            }

            .container table,
            .container th,
            .container td {
                border-color: #ddd;
                background-color: #f2f2f2;
                color: #000;
            }

            .header-table .logo img {
                width: 100px;
                display: block;
                margin: auto;
            }

            th {
                background-color: #f2f2f2;
                -webkit-print-color-adjust: exact;
            }

            button {
                display: none;
            }
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
                    <p>Rev: 0<br>Fecha: 17-abr-24<br>Página: 1 de 1</p>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Fecha de solicitud:</th>
                <td>19-ene-24</td>
                <th>Periodo del gasto:</th>
                <th>Del</th>
                <td>01-ene-24</td>
            </tr>
            <tr>
                <th>Fecha de requerido:</th>
                <td>31-ene-24</td>
                <td></td>
                <th>Al</th>                
                <td>25-ene-24</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <th>A nombre de (Beneficiario):</th>
                <td colspan="5">JOSE MANUEL TORRES VALENCIA</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Se solicita la cantidad de:</th>
                <td>$ 0.00</td>
                <th>como</th>
                <td>comprobación</td>
            </tr>
            <tr>
                <th>Cantidad con letra:</th>
                <td colspan="5">Cero</td>
            </tr>
            <tr>
                <th>Concepto o motivo del gasto:</th>
                <td colspan="5">Visita a Cardenas para recolección de material (Gasolina) (19-01-24)</td>
            </tr>
        </table>

        <h3>GASTOS REALIZADOS</h3>
        <table class="gastos-realizados-table">
            <tr>
                <th>Código QB</th>
                <td style="text-align: left;" colspan="3">Pasajes ()</td>
            </tr>
            <tr>
                <th>Factura</th>
                <th>Descripción</th>
                <th>Subtotal</th>
                <th>Total</th>
            </tr>
            <tr>
                <td></td>
                <td>Bitácora de Taxi</td>
                <td>$1,500.00</td>
                <td>$1,500.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="bold">$1,500.00</td>
                <td class="bold">$1,500.00</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="right bold">Subtotal</td>
                <td>$1,500.00</td>
            </tr>
            <tr>
                <td class="right bold">Total Comprobado</td>
                <td>$1,500.00</td>
            </tr>
            <tr>
                <td class="right bold">Total a Comprobar</td>
                <td>$1,500.00</td>
            </tr>
            <tr>
                <td class="right bold">Diferencia</td>
                <td class="bold">$0.00</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Departamento:</th>
                <td>Coordinador</td>
                <th>Proyecto (Quickbooks):</th>
                <td>GASOLINA</td>
            </tr>
            <tr>
                <td colspan="4" class="center bold underline">Si requiere transferencia electrónica, favor de llenar
                    los siguientes datos</td>
            </tr>
            <tr>
                <th class="center">Cuenta Bancaria</th>
                <td colspan="3" class="center">N/D (N/D: N/D)</td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <th>Solicita</th>
                <th>Autoriza</th>
                <th>Revisa</th>
            </tr>
            <tr class="sign-space">
                <td>JOSE MANUEL TORRES VALENCIA</td>
                <td>Erick Uriel Luria Hernandez</td>
                <td></td>
            </tr>
            <tr>
                <td>Nombre y Firma</td>
                <td>Nombre y Firma</td>
                <td>Nombre y Firma</td>
            </tr>
        </table>
    </div>

    <button onclick="window.print()">Vista Previa / Imprimir</button>

</body>

</html>
