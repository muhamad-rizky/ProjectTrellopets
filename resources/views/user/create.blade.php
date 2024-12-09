@extends('templates.app')


@section('content-dinamis')

<form action="{{ route('data_user.tambah.proses')}}" class="card p-5" method="POST">
    @csrf
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Username: </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email : </label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="role" class="col-sm-2 col-form-label">Role : </label>
        <div class="col-sm-10">
            <select class="form-select" name="role" id="role">
                <option selected disabled hidden>Pilih</option>
                <option value="admin" {{ old('role') == "admin" ? "selected" : "" }}>admin</option>
                <option value="kasir" {{ old('role') == "kasir" ? "selected" : "" }}>kasir</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Tambah</button>
</form>
@endsection
