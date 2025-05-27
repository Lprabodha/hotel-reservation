@extends('layouts.app')

@section('content')
    <!-- start of breadcumb-section -->
    {{-- @dd($hotels) --}}
    <div class="wpo-breadcumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-breadcumb-wrap">
                        <h2>Hotel</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><span>Hotel</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of wpo-breadcumb-section-->

    <!-- start of featured-->
    <section class="featured-section s2 section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="wpo-section-title s2">
                        <span>// featured hotels</span>
                        <h2>Discover the World's Most Captivating Featured Places</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                @forelse ($hotels as $hotel)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all new_york zoomIn"
                        data-wow-duration="2000ms">
                        <div class="featured-card">
                            <div class="image">
                                <img src="{{ Storage::disk('s3')->url($hotel->images[0]) }}" alt="Hotel Image"
                                    width="263px" height="240px">
                            </div>
                            <div class="content">
                                <div class="top-content">
                                    <ul>
                                        <li>
                                            <span>{{ $hotel->type->label() }}</span>
                                            <span class="date">Type</span>
                                        </li>
                                        <li>
                                            <span>{{ $hotel->star_rating }}</span>
                                            <span class="date">Rating</span>
                                        </li>
                                        <li>
                                            <span>{{ $hotel->country }}</span>
                                            <span class="date">Country</span>
                                        </li>
                                    </ul>
                                </div>
                                <h2><a href="#">{{ $hotel->name }}</a></h2>
                                <span><i class="ti-location-pin"></i>{{ $hotel->location }}</span>
                            </div>
                        </div>
                    </div>

                @empty
                    <div>No Hotels Available at this moment to show...</div>
                @endforelse
            </div>
            {{-- <div class="row"> --}}
            {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all new_york zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/1.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Whispering Pines</a></h2>
                            <span><i class="ti-location-pin"></i> Pine Tree Lane, Whisperwood</span>
                        </div>
                    </div>
                </div> --}}
            {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all london zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/2.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Serenity Vista In</a></h2>
                            <span><i class="ti-location-pin"></i>Serenity Avenue, Tranquil Town</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all tokyo zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/3.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Blissful Retreat Lodge</a></h2>
                            <span><i class="ti-location-pin"></i>321 Bliss Way, Serene Valley</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all new_york zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/4.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Radiant Moon Hotel</a></h2>
                            <span><i class="ti-location-pin"></i>Moonlight Boulevard, Starryville</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all london zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/5.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Whispering Pines</a></h2>
                            <span><i class="ti-location-pin"></i>Pine Tree Lane, Whisperwood</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all paris zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/6.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Velvet Sands Hotel</a></h2>
                            <span><i class="ti-location-pin"></i>753 Velvet Shore, Sandy Shores</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all tokyo zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/7.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Majestic Peaks Resort</a></h2>
                            <span><i class="ti-location-pin"></i>951 Majestic View, Mountainville</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all paris zoomIn" data-wow-duration="2000ms">
                    <div class="featured-card">
                        <div class="image">
                            <img src="{{asset('images/featured/8.jpg')}}" alt="">
                        </div>
                        <div class="content">
                            <div class="top-content">
                                <ul>
                                    <li>
                                        <span>$220</span>
                                        <span class="date">Night</span>
                                    </li>
                                    <li>
                                        <span>4.9</span>
                                        <span class="date">Rating</span>
                                    </li>
                                    <li>
                                        <span>08</span>
                                        <span class="date">Beds</span>
                                    </li>
                                </ul>
                            </div>
                            <h2><a href="{{route('hotel',['slug' => Str::uuid()])}}">Tranquil Oasis Inn</a></h2>
                            <span><i class="ti-location-pin"></i>258 Oasis Street, Calmington</span>
                        </div>
                    </div>
                </div> --}}
            {{-- </div> --}}
        </div>
    </section>
    <!-- end of featured-->
@endsection
