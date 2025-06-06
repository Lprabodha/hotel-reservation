@extends('layouts.app')

@section('content')
    <!-- start of breadcumb-section -->
    <div class="wpo-breadcumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-breadcumb-wrap">
                        <h2>Contact Us</h2>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><span>Contact</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of wpo-breadcumb-section-->


    <!-- start wpo-contact-pg-section -->
    <section class="wpo-contact-pg-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-lg-10 offset-lg-1">
                    <div class="office-info">
                        <div class="row">
                            <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                <div class="office-info-item">
                                    <div class="office-info-icon">
                                        <div class="icon">
                                            <i class="fi flaticon-placeholder"></i>
                                        </div>
                                    </div>
                                    <div class="office-info-text">
                                        <h2>Address</h2>
                                        <p>123 Galle Road, Colombo, Sri Lanka</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                <div class="office-info-item">
                                    <div class="office-info-icon">
                                        <div class="icon">
                                            <i class="fi flaticon-email"></i>
                                        </div>
                                    </div>
                                    <div class="office-info-text">
                                        <h2>Email Us</h2>
                                        <p>info@click2checkin.com</p>
                                        <p>support@click2checkin.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                <div class="office-info-item">
                                    <div class="office-info-icon">
                                        <div class="icon">
                                            <i class="fi flaticon-phone-call"></i>
                                        </div>
                                    </div>
                                    <div class="office-info-text">
                                        <h2>Call Now</h2>
                                        <p>+94 77 123 4567</p>
                                        <p>+94 77 123 2269</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wpo-contact-title">
                        <h2>Have Any Question?</h2>
                        <p>Finding the right stay is easy — but we’re here to help if you need anything along the way.</p>
                    </div>
                    <div class="wpo-contact-form-area">
                        <form method="post" class="contact-validation-active" id="contact-form-main">
                            <div>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Your Name*">
                            </div>
                            <div>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Your Email*">
                            </div>
                            <div>
                                <input type="text" class="form-control" name="adress" id="adress"
                                    placeholder="Adress">
                            </div>
                            <div>
                                <select name="subject" id="subject" class="form-control">
                                    <option disabled="disabled" selected>Customer Type</option>
                                    <option>Private User</option>
                                    <option>Travel Company</option>
                                </select>
                            </div>
                            <div class="fullwidth">
                                <textarea class="form-control" name="note" id="note" placeholder="Message..."></textarea>
                            </div>
                            <div class="submit-area">
                                <button type="submit" class="theme-btn">Get in Touch</button>
                                <div id="loader">
                                    <i class="ti-reload"></i>
                                </div>
                            </div>
                            <div class="clearfix error-handling-messages">
                                <div id="success">Thank you</div>
                                <div id="error"> Error occurred while sending email. Please try again later. </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end wpo-contact-pg-section -->

    <!--  start wpo-contact-map -->
    <section class="wpo-contact-map-section">
        <h2 class="hidden">Contact map</h2>
        <div class="wpo-contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126743.87298541254!2d80.1496373!3d6.0558916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae174d3f0f3e2d1%3A0x2b9b9b9b9b9b9b9b!2sGalle%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1622547890123!5m2!1sen!2slk"
                allowfullscreen></iframe>
        </div>
    </section>
    <!-- end wpo-contact-map -->
@endsection
