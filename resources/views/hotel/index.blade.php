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
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="text" name="check_in" id="check-in" autocomplete="off" class="form-control"
                            placeholder="Check In:" value="{{ $checkIn }}">
                    </div>
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="text" name="check_out" autocomplete="off" id="check-out" class="form-control"
                            placeholder="Check Out:" value="{{ $checkOut }}">
                    </div>
                    <div class="col-md-2 col-6" style="width: 24%">
                        <input type="number" name="guests" autocomplete="off" id="guests" class="form-control"
                            placeholder="Guests:" value="{{ $guests }}" min="1" max="10">
                    </div>
                    <div class="col-md-3 col-12 text-center" style="width: 24%">
                        <button type="submit" id="search-btn" class="search-btn">Search Hotel</button>
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
                    <div class="d-flex justify-content-center align-items-center bg-white text-center rounded shadow-sm flex-column py-5 px-4"
                        style="min-height: 300px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#6c757d" class="mb-3"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 1.5a6.5 6.5 0 1 1 0 13.001A6.5 6.5 0 0 1 8 1.5zm0 2a.75.75 0 0 1 .743.648L8.75 4.25v3a.75.75 0 0 1-1.493.102L7.25 7.25v-3a.75.75 0 0 1 .75-.75zm.002 6a.875.875 0 1 1 0 1.75.875.875 0 0 1 0-1.75z" />
                        </svg>

                        <h5 class="text-secondary fw-semibold mb-2">No Hotels Available</h5>
                        <p class="text-muted mb-3">Unfortunately, we couldn’t find any available hotels matching your search
                            criteria.</p>

                        <a href="{{ route('hotels') }}" class="btn btn-outline-primary btn-sm">
                            Explore All Hotels
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        document.getElementById('search-btn').addEventListener('click', function() {
            const checkIn = encodeURIComponent(document.getElementById('check-in').value);
            const checkOut = encodeURIComponent(document.getElementById('check-out').value);
            const guests = encodeURIComponent(document.getElementById('guests').value);

            const url = `{{ route('hotels') }}?check_in=${checkIn}&check_out=${checkOut}&guests=${guests}`;

            window.location.href = url;
        });

        document.getElementById('guests').addEventListener('input', function(e) {
            const max = 100;
            const min = 1;
            let value = parseInt(e.target.value, 10);

            if (value > max) e.target.value = max;
            if (value < min) e.target.value = min;
        });
    </script>
@endsection
