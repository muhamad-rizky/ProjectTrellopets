@extends('templates.app')


@section('content-dinamis')
    {{-- <div class="container">
    <h1>Create</h1>
</div> --}}

    <form action="{{ route('data_hewan.ubah.proses', $pet['id']) }}" method="POST" class="card p-5">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Nama Hewan: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="type" class="col-sm-2 col-form-label">Jenis Hewan: </label>
            <div class="col-sm-10">
                <select class="form-select" name="species" id="species">
                    <option selected disabled hidden>Pilih</option>
                    <option value="cat" {{ old('species', $pet['species']) == 'cat' ? 'selected' : '' }}>Cat</option>
                    <option value="dog" {{ old('species', $pet['species']) == 'dog' ? 'selected' : '' }}>Dog</option>
                    <option value="bird" {{ old('species', $pet['species']) == 'bird' ? 'selected' : '' }}>Bird</option>
                    <option value="fish" {{ old('species', $pet['species']) == 'fish' ? 'selected' : '' }}>Fish</option>
                    <option value="reptile" {{ old('species', $pet['species']) == 'reptile' ? 'selected' : '' }}>Reptile
                    </option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="price" class="col-sm-2 col-form-label">Harga: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ $pet['price'] }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
@endsection
