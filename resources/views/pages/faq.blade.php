@extends('layouts.app')

@section('content')
    <!-- start of breadcumb-section -->
    <div class="wpo-breadcumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-breadcumb-wrap">
                        <h2>Faq</h2>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><span>Faq</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of wpo-breadcumb-section-->


    <!-- start wpo-faq-section -->
    <section class="wpo-faq-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 offset-lg-2">
                    <div class="wpo-section-title">
                        <h2>Frequently Asked Question</h2>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-2">
                    <div class="wpo-faq-section">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="wpo-benefits-item">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                     How do I make a hotel reservation on Click2Checkin?
                                                </button>
                                            </h3>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Just search for your destination, choose your check-in and check-out dates, and select a hotel. Click “Book Now” and follow the steps to confirm your reservation.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    Can I cancel or change my booking?
                                                </button>
                                            </h3>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Yes. Most bookings can be changed or cancelled, depending on the hotel’s policy. You can manage your booking through your account dashboard or contact our support team for help.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Is it safe to pay online through Click2Checkin?
                                                </button>
                                            </h3>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Absolutely. We use secure payment gateways and encrypted technology to protect your personal and payment information.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    Do I need to create an account to check hotels?
                                                </button>
                                            </h3>
                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>No, you can check as a guest. But creating an account allows you to track your bookings, save preferences, and get exclusive deals.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Can travel agencies use Click2Checkin to book for their clients?
                                                </button>
                                            </h3>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Yes. Travel companies can register under a special account type and manage multiple bookings for their clients easily through our system.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end faq-section 

    <div class="question-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-section-title">
                        <h2>Do You Have Any Question?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="question-touch">
                        <h2>Get In Touch</h2>
                        <form method="post" class="contact-validation-active" id="contact-form" novalidate="novalidate">
                            <div class="half-col">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Your Name">
                            </div>
                            <div class="half-col">
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Email Address">
                            </div>
                            <div class="half-col">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="Subject">
                            </div>
                            <div>
                                <textarea class="form-control" name="note" id="note" placeholder="Your Question"></textarea>
                            </div>
                            <div class="submit-btn-wrapper">
                                <button type="submit" class="theme-btn">Submit Now</button>
                                <div id="loader">
                                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
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
        </div>
    </div> -->
@endsection
