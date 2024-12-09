@extends('templates.app')

@section('content-dinamis')
    <form action="{{ route('login.proses') }}" method="POST"
          class="card shadow-lg border-0 mx-auto my-4 p-4"
          style="max-width: 400px; background-color: #f9f9f9; border-radius: 15px;">
        @csrf
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif

        @if (Session::get('logout'))
            <div class="alert alert-primary">{{ Session::get('logout') }}</div>
        @endif
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password :</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn w-100 btn-primary mt-3">LOGIN</button>
    </form>
@endsection
