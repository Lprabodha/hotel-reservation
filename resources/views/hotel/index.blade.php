@extends('layouts.app')

@section('content')
    <style>
        .search-form {
            background: linear-gradient(135deg, #f0f4ff, #f7fafc);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-form .form-control {
            border-radius: 25px;
            height: 45px;
            padding: 0 20px;
            font-size: 14px;
        }

        .search-btn {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
            width: 100%;
        }

        .search-btn:hover {
            background: linear-gradient(to right, #0072ff, #00c6ff);
        }

        .featured-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .featured-card .image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .featured-card .content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .featured-card h2 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .featured-card h2 a {
            color: #333;
            text-decoration: none;
        }

        .featured-card span {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .featured-card .top-content ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .featured-card .top-content ul li {
            font-size: 12px;
            text-align: center;
        }

        .featured-card .top-content ul li span {
            display: block;
            font-size: 12px;
        }

        .see-availability-btn {
            margin-top: auto;
            padding: 8px 20px;
            background: #28a745;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            border-radius: 25px;
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }

        .see-availability-btn:hover {
            background: #218838;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .search-form .row>div {
                margin-bottom: 15px;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <div class="wpo-breadcumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-breadcumb-wrap">
                        <h2>Hotel List</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><span>Hotels</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <section class="featured-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="wpo-section-title s2">
                        <span>// featured hotels</span>
                        <h2>Discover the World's Most Captivating Featured Places</h2>
                    </div>
                </div>
            </div>

            <form action="" method="GET" class="search-form">
                <div class="row align-items-center" style="display: flex; flex-wrap: wrap; justify-content: between;">
                    {{-- <div class="col-md-3 col-12">
                        <input type="text" name="location" class="form-control" placeholder="Location:">
                    </div> --}}
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="date" name="checkin" class="form-control" placeholder="Check In:">
                    </div>
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="date" name="checkout" class="form-control" placeholder="Check Out:">
                    </div>
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="number" name="guests" class="form-control" placeholder="Guests:">
                    </div>
                    <div class="col-md-3 col-12 text-center" style="width: 24%">
                        <button type="submit" class="search-btn">Search Hotel</button>
                    </div>
                </div>
            </form>

            <!-- Hotel List -->
            <div class="row mt-1">
                @forelse ($hotels as $hotel)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 custom-grid all new_york zoomIn"
                        data-wow-duration="2000ms">
                        <div class="featured-card">
                            <div class="image">
                                <a href="{{ route('hotel', ['slug' => $hotel->slug]) }}">
                                    <img src="{{ $hotel->images && count($hotel->images) > 0
                                        ? Storage::disk('s3')->url($hotel->images[0])
                                        : Vite::asset('resources/images/default-hotel.webp') }}"
                                        alt="{{ $hotel->name }}" width="263px" height="240px">
                                </a>
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
                                <h2>
                                    <a href="{{ route('hotel', ['slug' => $hotel->slug]) }}">
                                        {{ $hotel->name }}
                                    </a>
                                </h2>
                                <span><i class="ti-location-pin"></i>{{ $hotel->location }}</span>
                            </div>
                        </div>
                    </div>

                @empty
                    <div>No Hotels Available at this moment to show...</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
