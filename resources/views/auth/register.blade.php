@extends('layouts.app')

@section('content')
    <div class="wpo-login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="wpo-accountWrapper" action="#">
                        <div class="wpo-accountInfo image">
                            <img src="{{asset('images/login.png')}}" alt="">
                        </div>
                        <div class="wpo-accountForm form-style">
                            <div class="fromTitle">
                                <h2>Signup</h2>
                                <p>Sign into your pages account</p>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Your name here..">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <label>Email</label>
                                    <input type="text" id="email" name="email" placeholder="Your email here..">
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="pwd2" type="password" placeholder="Your password here.."
                                            value="sfsg" name="pass">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default reveal3" type="button"><i
                                                    class="ti-eye"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="pwd3" type="password" placeholder="Your password here.."
                                            value="ssres" name="pass">
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
                            <p class="subText">Don't have an account? <a href="{{route('login')}}">Create free account</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
