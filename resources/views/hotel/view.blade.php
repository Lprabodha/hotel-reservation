@extends('layouts.app')

@section('content')
    <!-- start of breadcumb-section -->
    <div class="wpo-breadcumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-breadcumb-wrap">
                        <h2>Hotel Details</h2>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li><span>Hotel</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of wpo-breadcumb-section-->

    <!-- wpo-room-area-start -->
    <div class="wpo-room-area-s2 section-padding pb-0">
        <div class="container-fluid">
            <div class="room-wrap room-active owl-carousel">
                <div class="room-item">
                    <div class="room-img">
                        <img src="{{asset('images/room/1.jpg')}}" alt="">
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-img">
                        <img src="{{asset('images/room/2.jpg')}}" alt="">
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-img">
                        <img src="{{asset('images/room/3.jpg')}}" alt="">
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-img">
                        <img src="{{asset('images/room/4.jpg')}}" alt="">
                    </div>
                </div>
                <div class="room-item">
                    <div class="room-img">
                        <img src="{{asset('images/room/5.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .room-area-start -->

    <!--Start Room-details area-->
    <div class="Room-details-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="room-description">
                        <div class="room-title">
                            <h2>Description</h2>
                        </div>
                        <p class="p-wrap">It's difficult to find examples of lorem ipsum in use before Letraset made
                            it popular as a dummy text in the 1960s, although McClintock says he remembers coming
                            across the lorem ipsum passage in a book of old metal type samples.</p>
                        <p>So when is it okay to use lorem ipsum? First, lorem ipsum works well for staging. It's
                            like the props in a furniture store—filler text makes it look like someone is home. The
                            same Wordpress template might eventually be home to a fitness blog, a photography
                            website, or the online journal of a cupcake fanatic. Lorem ipsum helps them imagine what
                            the lived-in website might look like.</p>
                        <p>Second, use lorem ipsum if you think the placeholder text will be too distracting. For
                            specific projects, collaboration between copywriters and designers may be best, however,
                            like Karen McGrane said, draft copy has a way of turning any meeting about layout
                            decisions into a discussion about word choice. So don't be afraid to use lorem ipsum to
                            keep everyone focused.</p>
                    </div>
                    <div class="room-details-service">
                        <div class="row">
                            <div class="room-details-item">
                                <div class="row">
                                    <div class="col-md-5 col-sm-5">
                                        <div class="room-d-text">
                                            <div class="room-title">
                                                <h2>Amenities</h2>
                                            </div>
                                            <ul>
                                                <li><a href="#">Refrigerator and water</a></li>
                                                <li><a href="#">Air Conditioner Facilities</a></li>
                                                <li><a href="#">Fruits are always available</a></li>
                                                <li><a href="#">2 Sets of nightwear</a></li>
                                                <li><a href="#">Tables and Chairs</a></li>
                                                <li><a href="#">2 Elevator Available</a></li>
                                                <li><a href="#">Room Side Belcony</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="room-d-img">
                                            <img src="{{asset('images/room/img-7.jpg')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="room-d-img">
                                            <img src="{{asset('images/room/img-8.jpg')}}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="room-d-text2">
                                            <div class="room-title">
                                                <h2>Room Services</h2>
                                            </div>
                                            <ul>
                                                <li><a href="#">Daily Cleaning</a></li>
                                                <li><a href="#">Special Swimming Pool</a></li>
                                                <li><a href="#">Free Parking</a></li>
                                                <li><a href="#">Free-to-use smartphone </a></li>
                                                <li><a href="#">Free Wifi</a></li>
                                                <li><a href="#">2 Elevator Available</a></li>
                                                <li><a href="#">Room Side Belcony</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-area">
                        <div class="room-title">
                            <h2>Pricing Plans</h2>
                        </div>
                        <div class="pricing-table">
                            <table class="table-responsive pricing-wrap">
                                <thead>
                                    <tr>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                        <th>Sun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                        <td>$250</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="map-area">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.9147703055!2d-74.11976314309273!3d40.69740344223377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbd!4v1547528325671"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="room-review">
                        <div class="room-title">
                            <h2>Room Reviews</h2>
                        </div>
                        <div class="review-item">
                            <div class="review-img">
                                <img src="{{asset('images/room/r1.jpg')}}" alt="">
                            </div>
                            <div class="review-text">
                                <div class="r-title">
                                    <h2>Marry Watson</h2>
                                    <ul>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                    </ul>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                    gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                            </div>
                        </div>
                        <div class="review-item">
                            <div class="review-img">
                                <img src="{{asset('images/room/r2.jpg')}}" alt="">
                            </div>
                            <div class="review-text">
                                <div class="r-title">
                                    <h2>Lily Havenly</h2>
                                    <ul>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                        <li><i class="ti-star"></i></li>
                                    </ul>
                                </div>
                                <p> Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan
                                    lacus vel facilisis. </p>
                            </div>
                        </div>
                    </div>
                    <div class="add-review">
                        <div class="room-title">
                            <h2>Add Review</h2>
                        </div>
                        <div class="wpo-blog-single-section review-form ">
                            <div class="give-rat-sec">
                                <p>Your rating *</p>
                                <div class="give-rating">
                                    <label>
                                        <input type="radio" name="stars" value="1" />
                                        <span class="icon">★</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="stars" value="2" />
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="stars" value="3" />
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="stars" value="4" />
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="stars" value="5" />
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                        <span class="icon">★</span>
                                    </label>
                                </div>
                            </div>
                            <div class="review-add">
                                <div class="comment-respond">
                                    <form id="commentform" class="comment-form">
                                        <div class="form-inputs">
                                            <input placeholder="Your Name*" type="text">
                                            <input placeholder="Your Email*" type="email">
                                        </div>
                                        <div class="form-textarea">
                                            <textarea id="comment" placeholder="Your Review"></textarea>
                                        </div>
                                        <div class="form-check">
                                            <div class="shipp pb">
                                                <input type="checkbox" id="c2" name="cc">
                                                <label for="c2"><span></span>Save my name, email, and website in
                                                    this browser for the next time I comment.</label>
                                            </div>
                                        </div>
                                        <div class="form-submit">
                                            <input id="submit" value="Submit Now" type="submit">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--Start Room area-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="blog-sidebar room-sidebar">
                        <div class="widget check-widget">
                            <h3>Check Availability</h3>
                            <form>
                                <!-- Datepicker as text field -->
                                <div class="input-group date">
                                    <input autocomplete="off" type="text" id="check-in" placeholder="Check in">
                                    <i class="fi flaticon-calendar"></i>
                                </div>

                                <!-- Datepicker as text field -->
                                <div class="input-group date">
                                    <input autocomplete="off" type="text" id="check-out" placeholder="Check Out">
                                    <i class="fi flaticon-calendar"></i>
                                </div>

                                <div class="input-group date">
                                    <select name="Adults" id="Adults">
                                        <option value="">Adults</option>
                                        <option value="">2</option>
                                        <option value="">5</option>
                                        <option value="">1</option>
                                    </select>
                                </div>
                                <div class="input-group date">
                                    <select name="Children" id="Children">
                                        <option value="">Children</option>
                                        <option value="">2</option>
                                        <option value="">5</option>
                                        <option value="">1</option>
                                    </select>
                                </div>
                                <div class="input-group date">
                                    <a href="cart.html" class="theme-btn">Check Availability</a>
                                </div>
                            </form>
                        </div>
                        <div class="widget recent-post-widget">
                            <h3>Related Posts</h3>
                            <div class="posts">
                                <div class="post">
                                    <div class="img-holder">
                                        <img src="{{asset('images/recent-posts/img-1.jpg')}}" alt>
                                    </div>
                                    <div class="details">
                                        <h4><a href="blog-single.html">17 places you cannot ignore in Paris</a></h4>
                                        <span class="date">19 Jun 2021 </span>
                                    </div>
                                </div>
                                <div class="post">
                                    <div class="img-holder">
                                        <img src="{{asset('images/recent-posts/img-2.jpg')}}" alt>
                                    </div>
                                    <div class="details">
                                        <h4><a href="blog-single.html">Be Careful About This, When You Are In
                                                Snow</a></h4>
                                        <span class="date">22 May 2021 </span>
                                    </div>
                                </div>
                                <div class="post">
                                    <div class="img-holder">
                                        <img src="{{asset('images/recent-posts/img-3.jpg')}}" alt>
                                    </div>
                                    <div class="details">
                                        <h4><a href="blog-single.html">Things You Must Need To See While You’re In
                                                Dubai</a></h4>
                                        <span class="date">12 Apr 2021 </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget wpo-instagram-widget">
                            <div class="widget-title">
                                <h3>Discover Our Rooms</h3>
                            </div>
                            <ul class="d-flex">
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/1.jpg')}}"
                                            alt=""></a>
                                </li>
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/2.jpg')}}"
                                            alt=""></a>
                                </li>
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/3.jpg')}}"
                                            alt=""></a>
                                </li>
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/4.jpg')}}"
                                            alt=""></a>
                                </li>
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/5.jpg')}}"
                                            alt=""></a>
                                </li>
                                <li><a href="hotel-single.html"><img src="{{asset('images/instragram/6.jpg')}}"
                                            alt=""></a>
                                </li>
                            </ul>
                        </div>
                        <div class="wpo-contact-widget widget">
                            <h2>How We Can <br> Help You!</h2>
                            <p>labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo
                                viverra maecenas accumsan lacus vel facilisis. </p>
                            <a href="contact.html">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Room-details area-->

@endsection
