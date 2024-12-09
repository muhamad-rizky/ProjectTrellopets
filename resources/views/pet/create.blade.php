@extends('templates.app')


@section('content-dinamis')

    <form action="{{ route('data_hewan.tambah.proses') }}" class="card p-5" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
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
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Nama Hewan: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="price" class="col-sm-2 col-form-label">Harga: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="stock" class="col-sm-2 col-form-label">Stock: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="species" class="col-sm-2 col-form-label">Spesies: </label>
            <div class="col-sm-10">
                <select class="form-select" name="species" id="species">
                    <option selected disabled hidden>Pilih</option>
                    <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                    <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                    <option value="bird" {{ old('species') == 'bird' ? 'selected' : '' }}>Bird</option>
                    <option value="fish" {{ old('species') == 'fish' ? 'selected' : '' }}>Fish</option>
                    <option value="reptile" {{ old('species') == 'reptile' ? 'selected' : '' }}>Reptile</option>
                </select>
            </div>
        </div>
        {{-- <div class="row mb-3">
            <label for="image" class="col-sm-2 col-form-label">Image: </label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="image" name="image">
            </div>
        </div> --}}
        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
@endsection
