@include('layouts.header')

<div class="card">
    <div class="card-body">
        <div class="border p-4 rounded">
            <div class="form-body">
                <form class="row g-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-6 text-end">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div> -->

                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>{{ __('Login') }}</button>
                        </div>
                    </div>
                    <!-- <div class="text-center">
                        <p>Don't have an account yet? <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        </p>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')