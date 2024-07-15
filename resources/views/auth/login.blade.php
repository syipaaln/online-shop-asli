<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
    <body>
        <div class="container d-flex justify-content-center align-items-center vh-100" >
            <div class="card p-4" style="width: 100%; max-width: 400px; border: none;">
                <div class="text-center mb-4">
                    <a href="/" style="cursor: pointer;">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo TB DARMA" class="d-block mx-auto w-50">
                    </a>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="{{ __('Masukan Email Anda') }}" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  style="border: none;">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password Anda" @error('password') is-invalid @enderror name="password" required autocomplete="current-password"  style="border: none;">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    @if (Route::has('password.request'))
                    <div class="form-group text-right">
                        <a href="{{ route('password.request') }}" class="btn-link">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-block rounded-2">{{ __('LOGIN') }}</button>
                    <div class="text-center my-2">
                        <span>ATAU</span>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-block rounded-2">{{ __('REGISTER') }}</a>
                </form>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>





