<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="" />
    <title>Dashboard | Login Page </title>
    <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
</head>

<body>
    <div class="trail">
        <canvas id="world"></canvas>
    </div>
    <main class="container" style="opacity:1;">
        <div class="wrapper">
            <div class="form-area">
                <form class="border p-4 rounded shadow-sm" style="width: 400px;" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="text-center mb-4">Login</h3>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email address</label>
                        {{-- <input type="email" class="form-control" id="inputEmail" placeholder="Enter email"> --}}
                        {{-- ----------  --}}
                        <input placeholder="Enter email" id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email','admin@gmail.com') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        {{-- ----------  --}}
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        {{-- <input type="password" class="form-control" id="inputPassword" placeholder="Password"> --}}
                         <input value="12345678" placeholder="Enter Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="mb-3 form-check">
                        {{-- <input type="checkbox" class="form-check-input" id="rememberMe"> --}}
                         <input class="form-check-input" type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>


                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    {{-- <a href="#" type="submit" class="btn btn-primary d-block w-100 mb-3">Login</a> --}}
                    <button type="submit" class="btn btn-primary d-block w-100 mb-3">
                                    {{ __('Login') }}
                                </button>
                    <div class="text-center">
                          @if (Route::has('password.request'))
                                <a class="" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        {{-- <a href="forget-password.html" class="text-decoration-none me-3">Forgot Password?</a> --}}
                        <span class="text-muted">|</span>
                        <a href="{{route('register') }}" class="text-decoration-none ms-3">Sign Up</a>
                    </div>
                </form>
            </div>
            <!-- <div class="info-area"></div> -->
        </div>
    </main>
    <script src="{{ asset('backend/dist/js/login.js') }}"></script>
</body>

</html>
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

