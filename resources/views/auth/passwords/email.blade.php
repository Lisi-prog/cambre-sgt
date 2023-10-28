@extends('layouts.auth_app')
@section('title')
    Has olvidado tu contraseña
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Restablecer Contraseña</h4></div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" tabindex="1" value="{{ old('email') }}" autofocus required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                        Enviar link
                    </button>
                    <a href="{{ route('login') }}" tabindex="4" class="text-small btn btn-danger btn-lg btn-block">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Recalled your login info? <a href="{{ route('login') }}">Sign In</a>
    </div>
@endsection
