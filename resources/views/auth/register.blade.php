@extends('layouts.app')

@section('content')
    <div class="wpo-login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="wpo-accountWrapper" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="wpo-accountInfo image">
                            <img src="{{ Vite::asset('resources/images/img/login.png') }}" alt="">
                        </div>
                        <div class="wpo-accountForm form-style">
                            <div class="fromTitle">
                                <h2>Signup</h2>
                                <p>Create your account below</p>
                            </div>

                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-lg-12 col-md-12">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Your name here..." required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-lg-12 col-md-12">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Your email here..." required>
                                    @error('email')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-lg-12 col-md-12">
                                    <label for="password">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password" required>
                                        <button type="button" class="btn btn-sm btn-outline-secondary toggle-password"
                                            data-target="password" style="position:absolute; right:10px; top:7px;">
                                            <i class="ti-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-lg-12 col-md-12">
                                    <label for="password-confirm">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" id="password-confirm"
                                            class="form-control" placeholder="Confirm your password" required>
                                        <button type="button" class="btn btn-sm btn-outline-secondary toggle-password"
                                            data-target="password-confirm" style="position:absolute; right:10px; top:7px;">
                                            <i class="ti-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-lg-12">
                                    <button type="submit" class="wpo-accountBtn">Sign Up</button>
                                </div>

                                <h4 class="or"><span>OR</span></h4>

                                <!-- Google Login -->
                                <div class="d-flex justify-content-center mt-1">
                                    <a href="{{ route('social.login', 'google') }}"
                                        class="btn btn-light border d-flex align-items-center px-4 py-2 rounded shadow-sm"
                                        style="gap: 12px; font-weight: 500; font-size: 16px;">
                                        <img src="{{ asset('images/google-icon.png') }}" alt="Google"
                                            style="width:20px; height:20px;">
                                        <span>Log in with Google</span>
                                    </a>
                                </div>

                                <!-- Already Have Account -->
                                <p class="subText mt-3 text-center">
                                    Already have an account? <a href="{{ route('login') }}">Log In</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                if (input.type === 'password') {
                    input.type = 'text';
                    this.innerHTML = '<i class="ti-eye-off"></i>';
                } else {
                    input.type = 'password';
                    this.innerHTML = '<i class="ti-eye"></i>';
                }
            });
        });
    </script>
@endsection
