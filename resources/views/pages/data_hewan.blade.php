@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3" action="{{ route('data_hewan.data') }}" method="GET">
                {{-- 1. tag form harus ada action sama method
            2. value method GET/POST
            - GET : form yg fungsinya untuk mencari
            - POST : form yg fungsinya untuk menambah/menghapus/mengubah
            3. input harus ada attr name, name => mengambil data dr isian input agar bisa di proses di controller
            4. ada button/input yg type="submit"
            5. action
            - form untuk mencari : action ambil route yg menampilkan halaman blade ini (return view blade ini)
            - form bukan mencari : action terpisah dengan route return view bladenya
            --}}

                <input type="text" name="cari" placeholder="Cari Nama Hewan..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <form action="{{ route('data_hewan.data') }}" method="GET" class="me-2">
                <input type="hidden" name="sort_stock" value="stock">
                <button type="submit" class="btn btn-primary">Urutkan Stok</button>
            </form>
            {{-- <button class="btn btn-success">+ Tambah</button> --}}

            <a href="{{ route('data_hewan.tambah') }}" class="btn btn-success">+ Tambah</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success m-2">
                {{ Session::get('success') }}
            </div>
        @endif
        <table class="table-stripped table-bordered mt-3 table text-center">
            <thead>
                <th>#</th>
                <th>Nama Hewan</th>
                <th>Spesies</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                {{-- jika data Hewan kosong --}}
                @if (is_null($pets) || count($pets) <= 0)
                    <tr>
                        <td colspan="6">Data Hewan Kosong</td>
                    </tr>
                @else
                    {{-- $pets : dari compact controller nya, diakses dengan loop karna data $pets banyak (array)
                --}}
                    @foreach ($pets as $index => $item)
                        <tr>
                            <td>{{ ($pets->currentPage() - 1) * $pets->perpage() + ($index + 1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['species'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer"
                                onclick="ShowModalStock('{{ $item['id'] }}', '{{ $item['stock'] }}')">
                                {{ $item['stock'] }}</td>
                            {{-- $item['column_di_migration'] --}}
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('data_hewan.ubah', $item) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger"
                                    onclick="ShowModalDelete('{{ $item['id'] }}', '{{ $item['name'] }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- memanggil pagination --}}
        <div class="d-flex justify-content-end my-3">
            {{ $pets->links() }}
        </div>

        {{-- Modal Hapus --}}

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Hewan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Ingin Menghapus Data Hewan <b id="nama_Hewan"></b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Stock --}}

        <div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Stok Hewan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        console.log('test');

        function ShowModalDelete(id, name) {
            console.log(id, name);
            $('#nama_hewan').text(name);
            let url = "{{ route('data_hewan.hapus', ':id') }}";
            url = url.replace(':id', id);
            $('form').attr('action', url);
            $('#exampleModal').modal('show');
        }

        function ShowModalStock(id, stock) {
            $('#stock').val(stock);
            let url = "{{ route('data_hewan.ubah.stok', ':id') }}";
            url = url.replace(':id', id);
            $('form').attr('action', url);
            $('#modalEditStock').modal('show');
        }

        @if (Session::get('failed'))
            $(document).ready(function() {
                let id = "{{ Session::get('id') }}";
                let stock = "{{ Session::get('stock') }}";
                ShowModalStock(id, stock);
            });
        @endif
    </script>
@endpush
