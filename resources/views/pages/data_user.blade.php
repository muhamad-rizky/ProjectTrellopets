@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3" action="{{ route('data_user.data') }}" method="GET">
                {{-- 1. tag form harus ada action sama method
            2. value method GET/POST
            - GET : form yg fungsinya untuk mencari
            - POST : form yg fungsinya untuk menambah/menghapus/mengubah
            3. input harus ada attr name, name => mengambil data dr isian input agar bisa di proses di controller
            4. ada button/input yg type="submit"
            5. action
            - form untuk mencari : action ambil route yg menampilkan halaman blade ini (return view blade ini)
            - form bukan mencari : action terpisah dengan route return view bladenya --}}
                <input type="text" name="cari_user" placeholder="Cari Nama Hewan..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <a href="{{ route('data_user.tambah') }}" class="btn btn-success">+ Tambah</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-danger m-2">
                {{ Session::get('success') }}
            </div>
        @endif
        <table class="table-stripped table-bordered mt-3 table text-center">
            <thead>
                <th>#</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @forelse ($users as $index => $item)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perpage() + ($index + 1) }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['role'] }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('data_user.ubah', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <button type="submit" class="btn btn-danger"
                                onclick="ShowModalDelete('{{ $item['id'] }}', '{{ $item['name'] }}')">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Data User Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end my-3">
            {{ $users->links() }}
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda Yakin Ingin Menghapus Data Hewan <b id="nama_user"></b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
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
        function ShowModalDelete(id, name) {
            $('#nama_user').text(name);
            let url = "{{ route('data_user.hapus', ':id') }}";
            url = url.replace(':id', id);
            $('form').attr('action', url);
            $('#exampleModal').modal('show');
        }
    </script>
@endpush
