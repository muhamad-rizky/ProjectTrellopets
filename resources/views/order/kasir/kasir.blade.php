@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            @if (Auth::user()->role == 'admin')
                <form action="{{ route('admin.order.index') }}" method="GET" class="d-flex align-items-center">
                @else
                    <form action="{{ route('kasir.order.index') }}" method="GET" class="d-flex align-items-center">
            @endif
            <div class="d-flex gap-2">
                <input type="date" name="search_date" id="search_date" class="form-control"
                    value="{{ request('search_date') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Clear</a>
                @else
                    <a href="{{ route('kasir.order.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
            </form>

            @if (Auth::user()->role == 'admin')
                <a href="{{ route('admin.order.export') }}" class="btn btn-primary">Export Excel</a>
            @endif

            @if (Auth::user()->role == 'kasir')
                <a href="{{ route('kasir.order.create') }}" class="btn btn-primary">Tambah Order</a>
            @endif

        </div>
        <table class="table-bordered table-striped table-hover table">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Hewan</th>
                    <th>Pembeli</th>
                    <th>Kasir</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                    @if (Auth::user()->role == 'kasir')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perpage() + ($index + 1) }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach ($order->pets as $key => $pet)
                                    <li>{{ $pet['name_pet'] }} ({{ $pet['qty'] }}) : Rp.
                                        {{ number_format($pet['total_price'], 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->name_customer }}</td>
                        <td>{{ $order['user']['name'] }}</td>
                        <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::create($order->created_at)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d F, Y H:i:s') }}
                        </td>
                        @if (Auth::user()->role == 'kasir')
                            <td>
                                <a href="{{ route('kasir.order.download', $order->id) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-print"></i> Cetak Struk
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $orders->links() !!}
    </div>
    </div>
@endsection
