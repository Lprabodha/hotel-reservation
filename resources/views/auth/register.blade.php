@extends('layouts.app')

@section('content')
    <div class="wpo-login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="wpo-accountWrapper"method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="wpo-accountInfo image">
                            <img src="{{ asset('images/login.png') }}" alt="">
                        </div>
                        <div class="wpo-accountForm form-style">
                            <div class="fromTitle">
                                <h2>Signup</h2>
                                <p>Sign into your pages account</p>
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
                                        <input type="password" placeholder="Your password here.." 
                                            name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default reveal3" type="button"><i
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
                                        <input  id="password-confirm" type="password" placeholder="Your password here.."
                                            name="password_confirmation" required autocomplete="new-password">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default reveal2" type="button"><i
                                                    class="ti-eye"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <button type="submit" class="wpo-accountBtn">Sign Up</button>
                                </div>
                            </div>
                            <h4 class="or"><span>OR</span></h4>
                            <ul class="wpo-socialLoginBtn">
                                <li><button class="facebook" tabindex="0" type="button"><span><i
                                                class="ti-facebook"></i></span></button></li>
                                <li><button class="twitter" tabindex="0" type="button"><span><i
                                                class="ti-twitter"></i></span></button></li>
                                <li><button class="linkedin" tabindex="0" type="button"><span><i
                                                class="ti-linkedin"></i></span></button></li>
                            </ul>
                            <p class="subText">Don't have an account? <a href="{{ route('login') }}">Create free account</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
