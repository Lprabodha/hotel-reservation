        <!-- Start header -->
        <header id="header">
            <div class="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-7 col-sm-12 col-12">
                            <div class="contact-intro">
                                <ul>
                                    <li><i class="fi ti-location-pin"></i>28 Street, New York City, USA</li>
                                    <li><i class="fi flaticon-email"></i>service@click2checkin.com </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col col-md-5 col-sm-12 col-12">
                            <div class="contact-info">
                                <ul>
                                    <li><a href="{{route('about-us')}}">About Us</a></li>
                                    <li><a href="{{route('faq')}}">FAQ Us</a></li>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="#"><i class="ti-instagram"></i></a></li>
                                    <li><a href="#"><i class="ti-google"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end topbar -->


            <div class="wpo-site-header wpo-site-header-s2">
                <nav class="navigation navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-3 col-3 d-lg-none dl-block">
                                <div class="mobail-menu">
                                    <button type="button" class="navbar-toggler open-btn">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar first-angle"></span>
                                        <span class="icon-bar middle-angle"></span>
                                        <span class="icon-bar last-angle"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-4">
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="{{route('home')}}"><img src={{Vite::asset('resources/images/logo.png')}}
                                            alt="logo"></a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-1 col-1">
                                <div id="navbar" class="collapse navbar-collapse navigation-holder">
                                    <button class="menu-close"><i class="ti-close"></i></button>
                                    <ul class="nav navbar-nav mb-2 mb-lg-0">
                                        <li><a href="{{route('home')}}">Home</a></li>
                                        <li><a href="{{route('about-us')}}">about us</a></li>
                                        <li><a href="{{route('contact-us')}}">Contact</a></li>
                                    </ul>

                                </div><!-- end of nav-collapse -->
                            </div>
                            <div class="col-lg-3 col-md-4 col-4">
                                <div class="header-right">
                                    <div class="language">
                                        <select>
                                            <option value="" selected>English</option>
                                            <option value="">Spanish</option>
                                            <option value="">German</option>
                                            <option value="">Arabic</option>
                                        </select>
                                    </div>
                                    <div class="close-form">
                                        <a class="theme-btn" href="{{route('login')}}">sign up</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end of container -->
                </nav>
            </div>
        </header>
