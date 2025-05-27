@extends('layouts.auth')

@section('css')
<style>
    body {
        background-image: url('{{ asset('images/bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .login-box {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }

    .input-group .form-control {
        border-right: 0;
    }

    .input-group .input-group-text {
        border-left: 0;
        background-color: #fff;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<p class="login-box-msg">Sign in to start your session</p>

<form action="{{ route('login') }}" method="post">
    @csrf
    <div class="form-group">
        <div class="input-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                name="password" required autocomplete="current-password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
            Remember Me
            </label>
        </div>
        <button type="submit" class="btn btn-primary text-nowrap">Sign In</button>
</div>

</form>

<p class="mb-1">
    <a href="{{ route('password.request') }}">I forgot my password</a>
</p>
<p class="mb-0">
    <a href="{{ route('register')}}" class="text-center">Register a new membership</a>
</p>
@endsection
