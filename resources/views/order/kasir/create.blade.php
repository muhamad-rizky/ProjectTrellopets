@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-3">
        <form action="{{ route('kasir.order.store') }}" class="card m-auto p-5" method="POST">
            @csrf
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger">
                    {{ Session::get('failed') }}
                </div>
                @php
                    $valueFormBefore = Session::get('valueFormBefore');
                @endphp
            @endif

            <p>Penanggung Jawab : <b>{{ Auth::user()->name }}</b></p>
            <div class="row mb-3">
                <label for="name_costumer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name_customer" id="name_costumer"
                        value="{{ isset($valueFormBefore) ? $valueFormBefore['name_customer'] : '' }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="pets" class="col-sm-2 col-form-label">Hewan</label>
                <div class="col-sm-10">
                    @if (isset($valueFormBefore))
                        @foreach ($valueFormBefore['pets'] as $key => $pet)
                            <div id="pets-{{ $key }}" class="d-flex mt-3">
                                <select class="form-select mb-2" name="pets[]">
                                    <option selected hidden disabled>Pesanan 1</option>
                                    @foreach ($pets as $item)
                                        <option value="{{ $item->id }}" {{ $pet == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($key > 0)
                                    <div>
                                        <span style="cursor: pointer" class="text-danger"
                                            onclick="deleteSelect('pets-{{ $key }}')">X</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div id="pets-1" class="d-flex mt-3">
                            <select class="form-select" name="pets[]">
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($pets as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="wrap-pets"></div>
                    <br>
                    <p style="cursor: pointer" class="text-primary" id="add-select">+ tambah Hewan</p>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        let no = {{ isset($valueFormBefore) ? count($valueFormBefore['pets']) + 1 : 2 }};

        $("#add-select").on("click", function() {
            let el = `<div id="pets-${no}" class="d-flex mt-3">
                    <br><select class="form-select" name="pets[]">
                        <option selected hidden disabled>Pesanan ${no}</option>
                        @foreach ($pets as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        <span style="cursor: pointer" class="text-danger" onclick="deleteSelect('pets-${no}')">X</span>
                    </div>
                </div>`;

            $(".wrap-pets").append(el);

            no++;
        });

        function deleteSelect(elementId) {
            $(`#${elementId}`).remove();
            no--;
        }
    </script>
@endpush
