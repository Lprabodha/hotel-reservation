@extends('layouts.app')

@section('content')
    <!-- start page-wrapper -->
    <div class="page-wrapper">

        <div class="wpo-login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="wpo-accountWrapper" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="wpo-accountInfo image">
                                <img src="{{ Vite::asset('resources/images/img/login.png') }}" alt="Image">
                            </div>
                            <div class="wpo-accountForm form-style">
                                <div class="fromTitle">
                                    <h2>Login</h2>
                                    <p>Sign into your pages account</p>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus placeholder="Enter your email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password" placeholder="Enter your password">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal6" type="button"><i
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
                                        <div class="check-box-wrap">
                                            <div class="input-box">
                                                <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry">
                                                <label for="fruit4">Remember Me</label>
                                            </div>
                                            <div class="forget-btn">
                                                <a href="forgot.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="wpo-accountBtn">Login</button>
                                    </div>
                                </div>
                                <h4 class="or"><span>OR</span></h4>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('social.login', 'google') }}"
                                        class="btn btn-light border d-flex align-items-center px-4 py-2 rounded shadow-sm"
                                        style="gap: 12px; font-weight: 500; font-size: 16px;">
                                        <img src="{{ asset('images/google-icon.png') }}" alt="Google"
                                            style="width:20px; height:20px;">
                                        <span>Log in with Google</span>
                                    </a>
                                </div>
                                <p class="subText mt-1">Don't have an account? <a href="{{ route('register') }}">Create free
                                        account</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end of page-wrapper -->
@endsection
