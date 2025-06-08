@extends('layouts.app')

@section('content')
    <div class="wpo-login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="wpo-accountWrapper"method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="wpo-accountInfo image">
                            <img src="{{ Vite::asset('resources/images/img/login.png') }}" alt="">
                        </div>
                        <div class="wpo-accountForm form-style">
                            <div class="fromTitle">
                                <h2>Signup</h2>
                                <p>Sign into your account</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Your name here.."
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>


                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <label>{{ __('Email Address') }}</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Your email here.."
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required placeholder="Enter your password here...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default toggle-password" type="button"><i
                                                    class="ti-eye"></i></button>
                                        </span>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm your password here...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button"><i
                                                class="ti-eye"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="wpo-accountBtn">Sign Up</button>
                            </div>
                        </div>
                        <h4 class="or"><span>OR</span></h4>

                        <div class="d-flex justify-content-center mt-1">
                            <a href="{{ route('social.login', 'google') }}"
                                class="btn btn-light border d-flex align-items-center px-4 py-2 rounded shadow-sm"
                                style="gap: 12px; font-weight: 500; font-size: 16px;">
                                <img src="{{ asset('images/google-icon.png') }}" alt="Google"
                                    style="width:20px; height:20px;">
                                <span>Log in with Google</span>
                            </a>
                        </div>

                        <p class="subText mt-2">Do you already have an account? <a href="{{ route('login') }}">Log In</a>
                        </p>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.closest('.form-group').querySelector('input');
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });
    </script>
@endsection
