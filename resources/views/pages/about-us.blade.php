@extends('layouts.app')

@section('content')
  <!-- start of breadcumb-section -->
  <div class="wpo-breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wpo-breadcumb-wrap">
                    <h2>About Us</h2>
                    <ul>
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><span>About</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of wpo-breadcumb-section-->


<!-- start of places-videos-->
<section class="places-videos-section section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 order-xl-2  col-12">
                <div class="wpo-section-title s2 wow fadeInRightSlow" data-wow-duration="1700ms">
                    <span>// beautiful videos</span>
                    <h2>Explore the World Through Beautiful Videos.</h2>
                    <a href="about.html" class="theme-btn">list your property</a>
                </div>
            </div>
            <div class="col-xl-7 order-xl-1 col-12">
                <div class="videos-wraper videos-slide wow fadeInLeftSlow" data-wow-duration="1700ms">
                    <div class="top-slide">
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/1.jpg" alt="">
                                <div class="video-holder">
                                    <a href="https://www.youtube.com/embed/kcftdnS0YGE" class="video-btn"
                                        data-type="iframe">
                                        <div class="icon">
                                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none">
                                                <path
                                                    d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
                                                    fill="#120D2B" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/2.jpg" alt="">
                                <div class="video-holder">
                                    <a href="https://www.youtube.com/embed/kcftdnS0YGE" class="video-btn"
                                        data-type="iframe">
                                        <div class="icon">
                                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none">
                                                <path
                                                    d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
                                                    fill="#120D2B" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/3.jpg" alt="">
                                <div class="video-holder">
                                    <a href="https://www.youtube.com/embed/kcftdnS0YGE" class="video-btn"
                                        data-type="iframe">
                                        <div class="icon">
                                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none">
                                                <path
                                                    d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
                                                    fill="#120D2B" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/4.jpg" alt="">
                                <div class="video-holder">
                                    <a href="https://www.youtube.com/embed/kcftdnS0YGE" class="video-btn"
                                        data-type="iframe">
                                        <div class="icon">
                                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none">
                                                <path
                                                    d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
                                                    fill="#120D2B" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-slider">
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/1.jpg" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/2.jpg" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/3.jpg" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <img src="images/places-videos/4.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- end of places-videos-->


<!-- start of testimonial-->
<section class="testimonial-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="wpo-section-title  wow fadeInUp" data-wow-duration="1200ms">
                    <span>// customer testimonial</span>
                    <h2>Delighting Our Customers, One Smile at a Time</h2>
                </div>
            </div>
        </div>
        <div class="testimonial-slider owl-carousel">
            <div class="testimonial-card wow fadeInUp" data-wow-duration="1400ms">
                <div class="top-content">
                    <div class="image">
                        <img src="images/testimonial/1.jpg" alt="">
                    </div>
                    <div class="text">
                        <h3>Eleanor Pena</h3>
                        <span>Eleanor Pena</span>
                    </div>
                </div>
                <div class="content">
                    <p>“Ac turpis egestas sed tempus. Nulla aliquet porttitor lacus luctus accumsan tortor
                        posuere ac ut. Dignissim convallis aenean et tortor at risus viverra. Sagittis eu
                        volutpat odio facilisis mauris.”</p>
                </div>
            </div>
            <div class="testimonial-card wow fadeInUp" data-wow-duration="1600ms">
                <div class="top-content">
                    <div class="image">
                        <img src="images/testimonial/2.jpg" alt="">
                    </div>
                    <div class="text">
                        <h3>Theresa Webb</h3>
                        <span>Eleanor Pena</span>
                    </div>
                </div>
                <div class="content">
                    <p>“Ac turpis egestas sed tempus. Nulla aliquet porttitor lacus luctus accumsan tortor
                        posuere ac ut. Dignissim convallis aenean et tortor at risus viverra. Sagittis eu
                        volutpat odio facilisis mauris.”</p>
                </div>
            </div>
            <div class="testimonial-card wow fadeInUp" data-wow-duration="1800ms">
                <div class="top-content">
                    <div class="image">
                        <img src="images/testimonial/3.jpg" alt="">
                    </div>
                    <div class="text">
                        <h3>Darrell Steward</h3>
                        <span>Eleanor Pena</span>
                    </div>
                </div>
                <div class="content">
                    <p>“Ac turpis egestas sed tempus. Nulla aliquet porttitor lacus luctus accumsan tortor
                        posuere ac ut. Dignissim convallis aenean et tortor at risus viverra. Sagittis eu
                        volutpat odio facilisis mauris.”</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of testimonial-->

<!-- start of places-->
<section class="places-section section-padding">
    <div class="container">
        <div class="wraper">
            <div class="wpo-section-title s2 wow fadeInLeftSlow" data-wow-duration="1700ms">
                <span>// nearby places</span>
                <h2>Nearby Places to Satiate Your Wanderlust.</h2>
            </div>
            <div class="places-wraper">
                <div class="gap-spase">
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1200ms">
                    <div class="image">
                        <img src="images/places/1.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">France</a>
                        </h2>
                        <span>20 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1400ms">
                    <div class="image">
                        <img src="images/places/2.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">United States</a>
                        </h2>
                        <span>18 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1600ms">
                    <div class="image">
                        <img src="images/places/3.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">Australia</a>
                        </h2>
                        <span>28 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1200ms">
                    <div class="image">
                        <img src="images/places/4.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">Spain</a>
                        </h2>
                        <span>30 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1400ms">
                    <div class="image">
                        <img src="images/places/5.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">Greece</a>
                        </h2>
                        <span>38 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1600ms">
                    <div class="image">
                        <img src="images/places/6.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">Maldives</a>
                        </h2>
                        <span>22 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="1800ms">
                    <div class="image">
                        <img src="images/places/7.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">new York</a>
                        </h2>
                        <span>42 minutes drive</span>
                    </div>
                </div>
                <div class="places-item wow fadeInUp" data-wow-duration="2000ms">
                    <div class="image">
                        <img src="images/places/8.jpg" alt="">
                    </div>
                    <div class="content">
                        <h2>
                            <a href="places-single.html">thailand</a>
                        </h2>
                        <span>27 minutes drive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of places-->

<!-- start of blog-->
<section class="blog-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="wpo-section-title s2 wow fadeInUp" data-wow-duration="1200ms">
                    <span>// latest news</span>
                    <h2>oin Our Blog for Travel Stories That Fuel Your Adventurous Spirit.</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="blog-card wow fadeInUp" data-wow-duration="1500ms">
                    <div class="image">
                        <img src="images/blog/img-1.jpg" alt="">
                    </div>
                    <div class="content">
                        <div class="top-content">
                            <ul>
                                <li>
                                    <span>24 SEP 2023</span>
                                    <span class="date">DATE</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                            </ul>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="blog-single.html">Hotels Amidst Nature's Bounty for Nature
                                    Enthusiasts.</a>
                            </h2>
                            <a href="blog-single.html" class="blog-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="blog-card wow fadeInUp" data-wow-duration="1700ms">
                    <div class="image">
                        <img src="images/blog/img-2.jpg" alt="">
                    </div>
                    <div class="content">
                        <div class="top-content">
                            <ul>
                                <li>
                                    <span>24 SEP 2023</span>
                                    <span class="date">DATE</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                            </ul>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="blog-single.html">Chic Boutique Hotels to Elevate Your Stay.</a>
                            </h2>
                            <a href="blog-single.html" class="blog-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="blog-card wow fadeInUp" data-wow-duration="1900ms">
                    <div class="image">
                        <img src="images/blog/img-3.jpg" alt="">
                    </div>
                    <div class="content">
                        <div class="top-content">
                            <ul>
                                <li>
                                    <span>24 SEP 2023</span>
                                    <span class="date">DATE</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                                <li>
                                    <span>02K</span>
                                    <span class="date">Comment</span>
                                </li>
                            </ul>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="blog-single.html">Experience 5-Star Stays Without Breaking the
                                    Bank.</a>
                            </h2>
                            <a href="blog-single.html" class="blog-btn">read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of blog-->
@endsection
