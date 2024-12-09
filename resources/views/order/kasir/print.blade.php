@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Struk Pembelian Hewan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>PetShop XYZ</h5>
                                <p>Jl. Kesehatan No. 123<br>Kota Sehat, Indonesia</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>Tanggal: {{ date('d M Y') }}</h5>
                                <p>Nomor Struk: #{{ $order->id }}{{ $order->user_id }}</p>
                            </div>
                        </div>
                        <table class="table-bordered table">
                            <thead>
                                <tr>
                                    <th>Nama Hewan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order['pets'] as $item)
                                    <tr>
                                        <td>{{ $item['name_pet'] }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Total Pembayaran:</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <p>Terima kasih telah berbelanja di PetShop XYZ</p>
                        <a href="{{ route('kasir.order.index') }}" class="btn btn-primary mb-4">Kembali</a>
                        <a href="{{ route('kasir.order.download', $order['id']) }}" class="btn btn-danger mb-4">Export
                            PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
