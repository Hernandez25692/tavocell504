<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura Reparación #{{ $factura->id }} - TavoCell 504</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9fafb;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 25px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1e40af;
        }

        .logo {
            height: 80px;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 24px;
            margin: 10px 0 5px;
            color: #1e40af;
            text-transform: uppercase;
        }

        .invoice-number {
            font-size: 16px;
            color: #6b7280;
            margin-bottom: 15px;
        }

        .client-info {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .client-info p {
            margin: 5px 0;
        }

        .info-label {
            font-weight: bold;
            color: #111827;
            display: inline-block;
            width: 100px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th {
            background-color: #1e40af;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .totals-table {
            width: 50%;
            margin-left: auto;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-table .label {
            font-weight: bold;
            text-align: right;
            width: 60%;
        }

        .totals-table .amount {
            text-align: right;
            width: 40%;
        }

        .total-row {
            font-weight: bold;
            background-color: #f3f4f6;
        }

        .signature {
            margin-top: 50px;
            text-align: center;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-text {
            font-size: 12px;
            margin-top: 5px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .device-details {
            margin-top: 5px;
            font-size: 12px;
            color: #6b7280;
        }

        .highlight {
            color: #1e40af;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div>
                <img src="{{ public_path('Logo/logo_menu.png') }}" class="logo" alt="TavoCell 504 Logo">
            </div>
            <div class="company-info">
                Especialistas en Reparación de Dispositivos Móviles | Teléfono: 3238-4184
            </div>
            <h1 class="invoice-title">FACTURA DE REPARACIÓN</h1>
            <div class="invoice-number">No. {{ $factura->id }}</div>
        </div>

        <div class="client-info">
            <p><span class="info-label">Cliente:</span> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}</p>
            <p><span class="info-label">Teléfono:</span> {{ $factura->cliente->telefono ?? '-' }}</p>
            <p><span class="info-label">Fecha:</span> {{ $factura->created_at->format('d/m/Y') }}</p>
            <p><span class="info-label">Hora:</span> {{ $factura->created_at->format('h:i A') }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $reparacion->marca }} {{ $reparacion->modelo }}</strong>
                        <div class="device-details">IMEI: {{ $reparacion->imei ?? 'No registrado' }}</div>
                    </td>
                    <td>
                        <strong>Falla reportada:</strong> {{ $reparacion->falla_reportada }}<br>
                        <strong>Accesorios:</strong> {{ $reparacion->accesorios ?? 'Ninguno' }}<br>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td class="label">Costo Total:</td>
                <td class="amount">L. {{ number_format($reparacion->costo_total, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Total Abono:</td>
                <td class="amount">L. {{ number_format($reparacion->abono, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">Saldo Pendiente:</td>
                <td class="amount highlight">L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}
                </td>
            </tr>
        </table>

        <div class="signature">
            <div class="signature-text">Firma del Cliente</div>
            <div class="signature-line"></div>
        </div>

        <div class="bg-gray-50 border border-gray-300 p-4 mt-6 rounded text-sm leading-relaxed text-gray-800">
            <p class="font-bold text-tavocell-primary mb-2">📋 POLÍTICA DE REPARACIONES – TavoCell 504</p>
            <ul class="list-decimal pl-5 space-y-2">
                <li>No nos hacemos responsables por fallas ocultas no declaradas por el cliente, presentes en el
                    celular, que solo son identificadas en una revisión técnica completa.</li>
                <li>No nos hacemos responsables por celulares dejados en el taller por más de 30 días. El cliente
                    perderá todo derecho sobre el equipo, el cual pasará a ser reciclado y desechado.</li>
                <li>Si el cliente no aprueba el servicio de reparación, se cobrará un valor de revisión de <strong>L.
                        50.00</strong>.</li>
                <li>La garantía cubre únicamente la pieza reparada. No aplica si el celular es manipulado posteriormente
                    por terceros.</li>
                <li>Se recomienda al cliente no dejar chip, memorias ni cobertores. TavoCell 504 no se responsabiliza en
                    caso de pérdida.</li>
            </ul>
            <p class="text-center mt-4 font-semibold text-indigo-700">¡Gracias por confiar en <strong>TavoCell
                    504</strong>!</p>
        </div>

    </div>
</body>

</html>
