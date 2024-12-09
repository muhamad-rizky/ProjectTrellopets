@extends('templates.app')
{{-- extends : mengimport/memanggil file view (biasanya untuk template nya, isi dr template merupakan content tetap/content yg selalu ada di setiap halaman) --}}

{{-- section : mengisi element html ke yield dengan nama yg sama ke file templatenya --}}
@section('content-dinamis')
    @if (Session::get('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
        </div>
    @endif
    <div class="jumbotron px-5 py-4">
        <h1 class="display-4">Selamat datang {{ Auth::user()->name }}!</h1>
        <hr class="my-4">
        <p>Aplikasi ini digunakan hanya oleh pegawai administrator PETSHOP. Digunakan untuk mengelola data hewan,
            penyetokan,
            juga pembelian (kasir).</p>
    </div>
@endsection
