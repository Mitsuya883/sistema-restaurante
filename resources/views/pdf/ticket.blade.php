<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 11px; margin: 0; padding: 2px; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 5px; }
        .header h1 { margin: 0; font-size: 14px; font-weight: bold; }
        .info { margin-bottom: 8px; font-size: 10px; }
        .table-products { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-products th { text-align: left; border-bottom: 1px solid #000; font-size: 10px; }
        .table-products td { padding: 2px 0; font-size: 10px; }
        .totals { margin-top: 10px; border-top: 1px dashed #000; padding-top: 5px; text-align: right; }
        .row-total { display: flex; justify-content: space-between; }
        .footer { text-align: center; margin-top: 15px; font-size: 9px; border-top: 1px solid #000; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CEVICHERÍA EL SOLY</h1>
        <div>RUC: 20601234567</div> <div>Salaverry N°625, Ascope</div>
        <div>Telf: +51 974 363 148</div>
    </div>

    <div class="info">
        <center>
            <strong>
            @if($order->tipo_comprobante == 'factura')
                FACTURA ELECTRÓNICA
            @elseif($order->tipo_comprobante == 'boleta')
                BOLETA DE VENTA ELECTRÓNICA
            @else
                TICKET DE VENTA
            @endif
            </strong>
            <br>
            Serie: F001-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
        </center>

        <br>
        <strong>Fecha:</strong> {{ $order->updated_at->format('d/m/Y H:i:s') }}<br>

        @if($order->tipo_comprobante != 'ticket')
            <strong>Cliente:</strong> {{ strtoupper($order->razon_social) }}<br>

            @if($order->tipo_comprobante == 'factura')
                <strong>RUC:</strong> {{ $order->nro_documento }}<br>
                <strong>Dirección:</strong> {{ strtoupper($order->direccion_fiscal) }}<br>
            @else
                <strong>DNI:</strong> {{ $order->nro_documento }}<br>
            @endif
        @else
            <strong>Cliente:</strong> PUBLICO GENERAL<br>
        @endif
    </div>

    <table class="table-products">
        <thead>
            <tr>
                <th width="10%">Cant.</th>
                <th width="60%">Descripción</th>
                <th width="30%" style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->quantity }}</td>
                <td>{{ $detail->product->name }}</td>
                <td style="text-align: right;">{{ number_format($detail->quantity * $detail->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        @if($order->tipo_comprobante == 'factura')
            <table width="100%">
                <tr>
                    <td style="text-align: right;">OP. GRAVADA:</td>
                    <td style="text-align: right; width: 60px;">S/ {{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">I.G.V. (18%):</td>
                    <td style="text-align: right;">S/ {{ number_format($igv, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;"><strong>IMPORTE TOTAL:</strong></td>
                    <td style="text-align: right;"><strong>S/ {{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </table>
        @else
            <table width="100%">
                <tr>
                    <td style="text-align: right;"><strong>TOTAL A PAGAR:</strong></td>
                    <td style="text-align: right; width: 60px;"><strong>S/ {{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </table>
        @endif

        <div style="margin-top: 5px; font-size: 9px;">
            Forma de Pago: {{ strtoupper($order->payment_method == 'cash' ? 'Efectivo' : $order->payment_method) }}
        </div>
    </div>

    <div class="footer">
        Representación impresa del Comprobante Electrónico.<br>
        ¡Gracias por su visita!<br>
        Para consultas: admin@cevicheriasoly.com
    </div>
</body>
</html>
