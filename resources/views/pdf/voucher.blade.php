<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Pago</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #ddd; padding: 5px; text-align: left; }
        .total { text-align: right; font-weight: bold; font-size: 14px; margin-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RESTAURANTE EL BUEN SABOR</h2>
        <p>Av. Siempre Viva 123, Lima<br>RUC: 20123456789</p>

        <h3>{{ strtoupper($payment->receipt_type) }} DE VENTA</h3>
        <p>N° Operación: {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="info">
        <p><strong>Fecha:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Mesa:</strong> {{ $payment->order->table->name ?? 'Delivery' }}</p>
        <p><strong>Mozo:</strong> {{ $payment->order->user->name }}</p>
        <p><strong>Método de Pago:</strong> {{ strtoupper($payment->payment_method) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Producto</th>
                <th>P.Unit</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->order->details as $item)
                <tr>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        TOTAL A PAGAR: S/ {{ number_format($payment->amount, 2) }}
    </div>

    <div class="footer">
        <p>¡Gracias por su preferencia!</p>
        <p>Este documento no tiene valor fiscal oficial (Demo)</p>
    </div>
</body>
</html>
