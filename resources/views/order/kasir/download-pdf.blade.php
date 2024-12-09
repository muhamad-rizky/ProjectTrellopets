<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian Hewan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .text-right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Struk Pembelian Hewan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Petshop XYZ</h5>
                        <p>Jl. Kesehatan No. 123<br>Kota Sehat, Indonesia</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <h5>Tanggal: {{ date('d M Y') }}</h5>
                        {{-- <p>Nomor Struk: #{{ $order->id }}{{ $order->user_id }}</p> --}}
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Hewan</th>
                            <th>Spesies</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order['pets'] as $item)
                            <tr>
                                <td>{{ $item['name_pet'] }}</td>
                                <td>{{ $item['species'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Total Pembayaran: Rp. {{ number_format($order['total_price'], 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p>Terima kasih telah berbelanja di Petshop XYZ</p>
            </div>
        </div>
    </div>
</body>

</html>
