<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice_id }}</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            margin: auto;
        }

        .header {
            background: #0f172a;
            color: #fff;
            padding: 15px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .invoice-title {
            text-align: right;
        }

        .section {
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #2563eb;
            color: #fff;
            padding: 8px;
            font-size: 11px;
        }

        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            width: 300px;
            float: right;
            margin-top: 15px;
        }

        .summary td {
            padding: 6px;
        }

        .total {
            background: #2563eb;
            color: #fff;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <table>
                <tr>
                    <td class="logo">
                        TechMart
                    </td>

                    <td class="invoice-title">
                        <h2>INVOICE</h2>
                        Invoice #: {{ $invoice_id }}<br>
                        Date: {{ $date }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- BILLING -->
        <div class="section">
            <table width="100%">
                <tr>
                    <td width="60%">
                        <strong>Bill To:</strong><br>
                        {{ $customer_name }}<br>
                        {{ $customer_email }}<br>
                        {{ $address }}, {{ $city }}, {{ $province }}
                    </td>

                    <td width="40%">
                        <strong>Payment Method:</strong> {{ strtoupper($payment_method) }}<br>
                        <strong>Status:</strong> {{ ucfirst($payment_status) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- ITEMS -->
        <div class="section">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">Rs {{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right">Rs {{ number_format($item->sub_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTALS -->
        <table class="summary">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rs {{ number_format($subtotal, 2) }}</td>
            </tr>

            <tr>
                <td>Shipping</td>
                <td class="text-right">Rs {{ number_format($shipping, 2) }}</td>
            </tr>

            <tr>
                <td>Discount</td>
                <td class="text-right">- Rs {{ number_format($discount, 2) }}</td>
            </tr>

            <tr class="total">
                <td>Total</td>
                <td class="text-right">Rs {{ number_format($total, 2) }}</td>
            </tr>
        </table>

        <div style="clear:both"></div>

        <!-- FOOTER -->
        <div class="footer">
            Thank you for shopping with TechMart<br>
            Karachi, Pakistan • contact@techmart.pk • +92-21-111-832-628
        </div>

    </div>

</body>

</html>
