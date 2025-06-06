@extends('layouts.app')

@section('content')
    <section class="hero-section-s3">
        <div class="hero-wraper">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-12">
                        <div class="hero-content-slider">
                            <div class="item">
                                <h2 class="wow fadeInLeftSlow" data-wow-duration="1400ms">Escape to Paradise with Click2Checkin.</h2>
                                <p class="wow fadeInLeftSlow" data-wow-duration="1600ms">From golden beaches to cool hills, find the stay that suits your journey.</p>
                                <div class="hero-btn wow fadeInLeftSlow" data-wow-duration="1800ms">
                                    <a href="{{ route('hotel', ['slug' => Str::uuid()]) }}" class="theme-btn">find your
                                        hotel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <div class="header-booking wow fadeInRightSlow" data-wow-duration="1400ms">
                            <div class="title">
                                <h3>search room</h3>
                                <span>Discover and book your perfect stay</span>
                            </div>
                            <form>
                                <div class="input-item">
                                    <input class="form-control" type="text" placeholder="Location:">
                                    <div class="icon">
                                        <svg width="14" height="19" viewBox="0 0 14 19" fill="none">
                                            <path
                                                d="M7.101 18.386C6.653 17.798 6.268 17.266 5.946 16.79C4.532 14.802 3.384 12.891 2.502 11.057C2.222 10.469 2.005 9.965 1.851 9.545C1.641 8.985 1.487 8.46 1.389 7.97C0.983 5.912 1.466 4.113 2.838 2.573C4.14 1.089 5.813 0.388999 7.857 0.472999C8.767 0.500999 9.628 0.738999 10.44 1.187C11.252 1.621 11.938 2.209 12.498 2.951C13.058 3.693 13.429 4.512 13.611 5.408C13.835 6.514 13.772 7.613 13.422 8.705C12.82 10.595 11.819 12.611 10.419 14.753C10.013 15.383 9.376 16.307 8.508 17.525L7.626 18.764C7.598 18.792 7.577 18.813 7.563 18.827C7.549 18.855 7.493 18.827 7.395 18.743C7.311 18.659 7.213 18.54 7.101 18.386ZM10.566 6.794C10.58 6.276 10.461 5.786 10.209 5.324C9.971 4.848 9.628 4.463 9.18 4.169C8.746 3.861 8.27 3.693 7.752 3.665C7.164 3.637 6.618 3.749 6.114 4.001C5.624 4.239 5.232 4.589 4.938 5.051C4.644 5.513 4.483 6.045 4.455 6.647C4.427 7.165 4.539 7.662 4.791 8.138C5.057 8.6 5.414 8.985 5.862 9.293C6.31 9.587 6.793 9.741 7.311 9.755C7.885 9.783 8.417 9.678 8.907 9.44C9.397 9.188 9.789 8.831 10.083 8.369C10.377 7.907 10.538 7.382 10.566 6.794Z"
                                                fill="#273958" />
                                        </svg>

                                    </div>
                                </div>
                                <div class="input-item">
                                    <input class="form-control" type="text" id="check-in" placeholder="Check In:">
                                    <div class="icon">
                                        <svg width="13" height="16" viewBox="0 0 13 16" fill="none">
                                            <path
                                                d="M12.95 2.86V14.095C12.95 14.495 12.86 14.785 12.68 14.965C12.5 15.155 12.205 15.25 11.795 15.25H1.205C0.805 15.25 0.51 15.155 0.32 14.965C0.14 14.785 0.05 14.495 0.05 14.095V2.905C0.05 2.515 0.15 2.225 0.35 2.035C0.55 1.835 0.84 1.74 1.22 1.75C1.34 1.76 1.425 1.785 1.475 1.825C1.525 1.865 1.545 1.945 1.535 2.065C1.515 2.445 1.515 2.825 1.535 3.205C1.555 3.535 1.65 3.79 1.82 3.97C1.99 4.15 2.235 4.245 2.555 4.255C2.925 4.285 3.275 4.28 3.605 4.24C3.885 4.21 4.105 4.105 4.265 3.925C4.425 3.745 4.51 3.51 4.52 3.22V2.08C4.51 1.97 4.525 1.89 4.565 1.84C4.605 1.78 4.685 1.75 4.805 1.75C5.935 1.76 7.06 1.76 8.18 1.75C8.3 1.75 8.38 1.775 8.42 1.825C8.47 1.875 8.49 1.96 8.48 2.08C8.47 2.24 8.47 2.48 8.48 2.8V3.16C8.49 3.49 8.585 3.75 8.765 3.94C8.945 4.13 9.195 4.24 9.515 4.27C9.835 4.29 10.15 4.29 10.46 4.27C10.78 4.24 11.025 4.135 11.195 3.955C11.365 3.775 11.46 3.53 11.48 3.22C11.5 2.84 11.5 2.46 11.48 2.08C11.48 1.96 11.5 1.88 11.54 1.84C11.58 1.79 11.66 1.76 11.78 1.75C12.16 1.74 12.45 1.83 12.65 2.02C12.85 2.21 12.95 2.49 12.95 2.86ZM1.52 5.515V7.48C1.52 7.58 1.54 7.65 1.58 7.69C1.62 7.73 1.69 7.75 1.79 7.75H4.22C4.32 7.75 4.395 7.735 4.445 7.705C4.495 7.675 4.52 7.61 4.52 7.51C4.51 6.83 4.51 6.155 4.52 5.485C4.52 5.325 4.435 5.245 4.265 5.245H1.805C1.705 5.245 1.63 5.265 1.58 5.305C1.54 5.345 1.52 5.415 1.52 5.515ZM4.52 13.48C4.51 12.83 4.51 12.185 4.52 11.545C4.52 11.435 4.495 11.36 4.445 11.32C4.405 11.28 4.33 11.26 4.22 11.26C4.04 11.27 3.77 11.27 3.41 11.26H2.6C2.24 11.27 1.97 11.27 1.79 11.26C1.69 11.26 1.62 11.28 1.58 11.32C1.54 11.36 1.52 11.43 1.52 11.53V12.175C1.53 12.745 1.53 13.175 1.52 13.465C1.52 13.575 1.545 13.655 1.595 13.705C1.645 13.755 1.73 13.78 1.85 13.78C2.65 13.76 3.445 13.76 4.235 13.78C4.335 13.78 4.405 13.755 4.445 13.705C4.495 13.665 4.52 13.59 4.52 13.48ZM4.175 10.765C4.305 10.775 4.395 10.755 4.445 10.705C4.505 10.655 4.53 10.565 4.52 10.435C4.51 9.815 4.51 9.2 4.52 8.59C4.52 8.46 4.5 8.37 4.46 8.32C4.42 8.26 4.335 8.235 4.205 8.245C3.415 8.255 2.63 8.255 1.85 8.245C1.73 8.245 1.645 8.265 1.595 8.305C1.545 8.345 1.52 8.425 1.52 8.545C1.54 9.175 1.54 9.81 1.52 10.45C1.51 10.57 1.535 10.655 1.595 10.705C1.655 10.755 1.745 10.775 1.865 10.765C2.035 10.755 2.29 10.755 2.63 10.765H3.395C3.745 10.755 4.005 10.755 4.175 10.765ZM5.3 5.245C5.2 5.245 5.125 5.265 5.075 5.305C5.035 5.335 5.015 5.4 5.015 5.5C5.035 6.16 5.035 6.82 5.015 7.48C5.015 7.58 5.035 7.65 5.075 7.69C5.115 7.73 5.185 7.75 5.285 7.75C5.455 7.74 5.715 7.74 6.065 7.75H6.875C7.235 7.74 7.505 7.74 7.685 7.75C7.795 7.75 7.87 7.73 7.91 7.69C7.96 7.65 7.985 7.575 7.985 7.465C7.975 7.175 7.975 6.745 7.985 6.175V5.53C7.985 5.42 7.96 5.345 7.91 5.305C7.87 5.255 7.795 5.235 7.685 5.245C6.895 5.245 6.1 5.245 5.3 5.245ZM5.015 8.545C5.035 9.195 5.035 9.835 5.015 10.465C5.015 10.595 5.04 10.68 5.09 10.72C5.14 10.76 5.225 10.775 5.345 10.765C5.515 10.755 5.765 10.755 6.095 10.765H6.89C7.25 10.755 7.52 10.755 7.7 10.765C7.8 10.775 7.87 10.76 7.91 10.72C7.96 10.67 7.985 10.59 7.985 10.48V8.545C7.985 8.435 7.965 8.36 7.925 8.32C7.885 8.27 7.81 8.245 7.7 8.245C6.9 8.265 6.1 8.265 5.3 8.245C5.19 8.245 5.115 8.27 5.075 8.32C5.035 8.36 5.015 8.435 5.015 8.545ZM7.985 13.435C7.975 12.815 7.975 12.2 7.985 11.59C7.995 11.46 7.97 11.37 7.91 11.32C7.86 11.27 7.77 11.25 7.64 11.26C7.47 11.27 7.22 11.27 6.89 11.26H6.11C5.76 11.27 5.5 11.27 5.33 11.26C5.21 11.25 5.125 11.27 5.075 11.32C5.035 11.37 5.015 11.455 5.015 11.575C5.035 12.205 5.035 12.835 5.015 13.465C5.005 13.585 5.025 13.665 5.075 13.705C5.125 13.755 5.21 13.78 5.33 13.78C6.11 13.77 6.885 13.77 7.655 13.78C7.775 13.78 7.86 13.755 7.91 13.705C7.97 13.655 7.995 13.565 7.985 13.435ZM8.48 5.53C8.5 6.16 8.5 6.79 8.48 7.42C8.47 7.55 8.49 7.64 8.54 7.69C8.6 7.74 8.695 7.76 8.825 7.75C8.995 7.74 9.245 7.74 9.575 7.75H11.21C11.31 7.75 11.38 7.73 11.42 7.69C11.47 7.65 11.495 7.58 11.495 7.48C11.485 6.83 11.485 6.185 11.495 5.545C11.495 5.425 11.47 5.345 11.42 5.305C11.37 5.255 11.285 5.235 11.165 5.245H8.765C8.665 5.235 8.59 5.255 8.54 5.305C8.5 5.345 8.48 5.42 8.48 5.53ZM11.48 13.51V11.53C11.49 11.43 11.47 11.36 11.42 11.32C11.38 11.28 11.31 11.26 11.21 11.26C11.03 11.27 10.76 11.27 10.4 11.26H8.78C8.68 11.26 8.605 11.275 8.555 11.305C8.505 11.335 8.48 11.4 8.48 11.5V13.525C8.48 13.695 8.565 13.78 8.735 13.78C9.565 13.76 10.39 13.76 11.21 13.78C11.4 13.78 11.49 13.69 11.48 13.51ZM11.135 10.765C11.265 10.775 11.355 10.76 11.405 10.72C11.465 10.67 11.495 10.575 11.495 10.435C11.475 9.815 11.475 9.19 11.495 8.56C11.495 8.44 11.47 8.36 11.42 8.32C11.37 8.27 11.285 8.245 11.165 8.245H8.78C8.67 8.245 8.59 8.265 8.54 8.305C8.5 8.345 8.48 8.42 8.48 8.53C8.49 8.82 8.49 9.255 8.48 9.835V10.495C8.48 10.595 8.5 10.665 8.54 10.705C8.58 10.745 8.65 10.765 8.75 10.765C8.93 10.755 9.2 10.755 9.56 10.765H10.355C10.705 10.755 10.965 10.755 11.135 10.765ZM3.08 3.745C2.83 3.765 2.605 3.695 2.405 3.535C2.205 3.365 2.09 3.15 2.06 2.89C1.98 2.3 1.98 1.7 2.06 1.09C2.1 0.829999 2.215 0.619999 2.405 0.46C2.605 0.299999 2.83 0.229999 3.08 0.25C3.34 0.269999 3.555 0.374999 3.725 0.564999C3.895 0.744999 3.99 0.964999 4.01 1.225C4.02 1.335 4.02 1.505 4.01 1.735V2.245C4.02 2.485 4.02 2.665 4.01 2.785C3.99 3.045 3.89 3.27 3.71 3.46C3.54 3.64 3.33 3.735 3.08 3.745ZM9.95 3.745C9.68 3.735 9.455 3.635 9.275 3.445C9.095 3.255 9 3.015 8.99 2.725C8.97 2.245 8.97 1.755 8.99 1.255C9 0.974999 9.095 0.739999 9.275 0.549999C9.465 0.359999 9.695 0.264999 9.965 0.264999C10.235 0.255 10.465 0.345 10.655 0.535C10.855 0.715 10.96 0.945 10.97 1.225C10.99 1.355 10.995 1.555 10.985 1.825V2.275C10.995 2.475 10.995 2.63 10.985 2.74C10.965 3.04 10.855 3.285 10.655 3.475C10.465 3.665 10.23 3.755 9.95 3.745Z"
                                                fill="#273958" />
                                        </svg>

                                    </div>
                                </div>
                                <div class="input-item">
                                    <input class="form-control" type="text" id="check-out" placeholder="Check Out:">
                                    <div class="icon">
                                        <svg width="13" height="16" viewBox="0 0 13 16" fill="none">
                                            <path
                                                d="M12.95 2.86V14.095C12.95 14.495 12.86 14.785 12.68 14.965C12.5 15.155 12.205 15.25 11.795 15.25H1.205C0.805 15.25 0.51 15.155 0.32 14.965C0.14 14.785 0.05 14.495 0.05 14.095V2.905C0.05 2.515 0.15 2.225 0.35 2.035C0.55 1.835 0.84 1.74 1.22 1.75C1.34 1.76 1.425 1.785 1.475 1.825C1.525 1.865 1.545 1.945 1.535 2.065C1.515 2.445 1.515 2.825 1.535 3.205C1.555 3.535 1.65 3.79 1.82 3.97C1.99 4.15 2.235 4.245 2.555 4.255C2.925 4.285 3.275 4.28 3.605 4.24C3.885 4.21 4.105 4.105 4.265 3.925C4.425 3.745 4.51 3.51 4.52 3.22V2.08C4.51 1.97 4.525 1.89 4.565 1.84C4.605 1.78 4.685 1.75 4.805 1.75C5.935 1.76 7.06 1.76 8.18 1.75C8.3 1.75 8.38 1.775 8.42 1.825C8.47 1.875 8.49 1.96 8.48 2.08C8.47 2.24 8.47 2.48 8.48 2.8V3.16C8.49 3.49 8.585 3.75 8.765 3.94C8.945 4.13 9.195 4.24 9.515 4.27C9.835 4.29 10.15 4.29 10.46 4.27C10.78 4.24 11.025 4.135 11.195 3.955C11.365 3.775 11.46 3.53 11.48 3.22C11.5 2.84 11.5 2.46 11.48 2.08C11.48 1.96 11.5 1.88 11.54 1.84C11.58 1.79 11.66 1.76 11.78 1.75C12.16 1.74 12.45 1.83 12.65 2.02C12.85 2.21 12.95 2.49 12.95 2.86ZM1.52 5.515V7.48C1.52 7.58 1.54 7.65 1.58 7.69C1.62 7.73 1.69 7.75 1.79 7.75H4.22C4.32 7.75 4.395 7.735 4.445 7.705C4.495 7.675 4.52 7.61 4.52 7.51C4.51 6.83 4.51 6.155 4.52 5.485C4.52 5.325 4.435 5.245 4.265 5.245H1.805C1.705 5.245 1.63 5.265 1.58 5.305C1.54 5.345 1.52 5.415 1.52 5.515ZM4.52 13.48C4.51 12.83 4.51 12.185 4.52 11.545C4.52 11.435 4.495 11.36 4.445 11.32C4.405 11.28 4.33 11.26 4.22 11.26C4.04 11.27 3.77 11.27 3.41 11.26H2.6C2.24 11.27 1.97 11.27 1.79 11.26C1.69 11.26 1.62 11.28 1.58 11.32C1.54 11.36 1.52 11.43 1.52 11.53V12.175C1.53 12.745 1.53 13.175 1.52 13.465C1.52 13.575 1.545 13.655 1.595 13.705C1.645 13.755 1.73 13.78 1.85 13.78C2.65 13.76 3.445 13.76 4.235 13.78C4.335 13.78 4.405 13.755 4.445 13.705C4.495 13.665 4.52 13.59 4.52 13.48ZM4.175 10.765C4.305 10.775 4.395 10.755 4.445 10.705C4.505 10.655 4.53 10.565 4.52 10.435C4.51 9.815 4.51 9.2 4.52 8.59C4.52 8.46 4.5 8.37 4.46 8.32C4.42 8.26 4.335 8.235 4.205 8.245C3.415 8.255 2.63 8.255 1.85 8.245C1.73 8.245 1.645 8.265 1.595 8.305C1.545 8.345 1.52 8.425 1.52 8.545C1.54 9.175 1.54 9.81 1.52 10.45C1.51 10.57 1.535 10.655 1.595 10.705C1.655 10.755 1.745 10.775 1.865 10.765C2.035 10.755 2.29 10.755 2.63 10.765H3.395C3.745 10.755 4.005 10.755 4.175 10.765ZM5.3 5.245C5.2 5.245 5.125 5.265 5.075 5.305C5.035 5.335 5.015 5.4 5.015 5.5C5.035 6.16 5.035 6.82 5.015 7.48C5.015 7.58 5.035 7.65 5.075 7.69C5.115 7.73 5.185 7.75 5.285 7.75C5.455 7.74 5.715 7.74 6.065 7.75H6.875C7.235 7.74 7.505 7.74 7.685 7.75C7.795 7.75 7.87 7.73 7.91 7.69C7.96 7.65 7.985 7.575 7.985 7.465C7.975 7.175 7.975 6.745 7.985 6.175V5.53C7.985 5.42 7.96 5.345 7.91 5.305C7.87 5.255 7.795 5.235 7.685 5.245C6.895 5.245 6.1 5.245 5.3 5.245ZM5.015 8.545C5.035 9.195 5.035 9.835 5.015 10.465C5.015 10.595 5.04 10.68 5.09 10.72C5.14 10.76 5.225 10.775 5.345 10.765C5.515 10.755 5.765 10.755 6.095 10.765H6.89C7.25 10.755 7.52 10.755 7.7 10.765C7.8 10.775 7.87 10.76 7.91 10.72C7.96 10.67 7.985 10.59 7.985 10.48V8.545C7.985 8.435 7.965 8.36 7.925 8.32C7.885 8.27 7.81 8.245 7.7 8.245C6.9 8.265 6.1 8.265 5.3 8.245C5.19 8.245 5.115 8.27 5.075 8.32C5.035 8.36 5.015 8.435 5.015 8.545ZM7.985 13.435C7.975 12.815 7.975 12.2 7.985 11.59C7.995 11.46 7.97 11.37 7.91 11.32C7.86 11.27 7.77 11.25 7.64 11.26C7.47 11.27 7.22 11.27 6.89 11.26H6.11C5.76 11.27 5.5 11.27 5.33 11.26C5.21 11.25 5.125 11.27 5.075 11.32C5.035 11.37 5.015 11.455 5.015 11.575C5.035 12.205 5.035 12.835 5.015 13.465C5.005 13.585 5.025 13.665 5.075 13.705C5.125 13.755 5.21 13.78 5.33 13.78C6.11 13.77 6.885 13.77 7.655 13.78C7.775 13.78 7.86 13.755 7.91 13.705C7.97 13.655 7.995 13.565 7.985 13.435ZM8.48 5.53C8.5 6.16 8.5 6.79 8.48 7.42C8.47 7.55 8.49 7.64 8.54 7.69C8.6 7.74 8.695 7.76 8.825 7.75C8.995 7.74 9.245 7.74 9.575 7.75H11.21C11.31 7.75 11.38 7.73 11.42 7.69C11.47 7.65 11.495 7.58 11.495 7.48C11.485 6.83 11.485 6.185 11.495 5.545C11.495 5.425 11.47 5.345 11.42 5.305C11.37 5.255 11.285 5.235 11.165 5.245H8.765C8.665 5.235 8.59 5.255 8.54 5.305C8.5 5.345 8.48 5.42 8.48 5.53ZM11.48 13.51V11.53C11.49 11.43 11.47 11.36 11.42 11.32C11.38 11.28 11.31 11.26 11.21 11.26C11.03 11.27 10.76 11.27 10.4 11.26H8.78C8.68 11.26 8.605 11.275 8.555 11.305C8.505 11.335 8.48 11.4 8.48 11.5V13.525C8.48 13.695 8.565 13.78 8.735 13.78C9.565 13.76 10.39 13.76 11.21 13.78C11.4 13.78 11.49 13.69 11.48 13.51ZM11.135 10.765C11.265 10.775 11.355 10.76 11.405 10.72C11.465 10.67 11.495 10.575 11.495 10.435C11.475 9.815 11.475 9.19 11.495 8.56C11.495 8.44 11.47 8.36 11.42 8.32C11.37 8.27 11.285 8.245 11.165 8.245H8.78C8.67 8.245 8.59 8.265 8.54 8.305C8.5 8.345 8.48 8.42 8.48 8.53C8.49 8.82 8.49 9.255 8.48 9.835V10.495C8.48 10.595 8.5 10.665 8.54 10.705C8.58 10.745 8.65 10.765 8.75 10.765C8.93 10.755 9.2 10.755 9.56 10.765H10.355C10.705 10.755 10.965 10.755 11.135 10.765ZM3.08 3.745C2.83 3.765 2.605 3.695 2.405 3.535C2.205 3.365 2.09 3.15 2.06 2.89C1.98 2.3 1.98 1.7 2.06 1.09C2.1 0.829999 2.215 0.619999 2.405 0.46C2.605 0.299999 2.83 0.229999 3.08 0.25C3.34 0.269999 3.555 0.374999 3.725 0.564999C3.895 0.744999 3.99 0.964999 4.01 1.225C4.02 1.335 4.02 1.505 4.01 1.735V2.245C4.02 2.485 4.02 2.665 4.01 2.785C3.99 3.045 3.89 3.27 3.71 3.46C3.54 3.64 3.33 3.735 3.08 3.745ZM9.95 3.745C9.68 3.735 9.455 3.635 9.275 3.445C9.095 3.255 9 3.015 8.99 2.725C8.97 2.245 8.97 1.755 8.99 1.255C9 0.974999 9.095 0.739999 9.275 0.549999C9.465 0.359999 9.695 0.264999 9.965 0.264999C10.235 0.255 10.465 0.345 10.655 0.535C10.855 0.715 10.96 0.945 10.97 1.225C10.99 1.355 10.995 1.555 10.985 1.825V2.275C10.995 2.475 10.995 2.63 10.985 2.74C10.965 3.04 10.855 3.285 10.655 3.475C10.465 3.665 10.23 3.755 9.95 3.745Z"
                                                fill="#273958" />
                                        </svg>

                                    </div>
                                </div>
                                <div class="input-item">
                                    <input class="form-control" type="text" placeholder="Guests:">
                                    <div class="icon">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none">
                                            <path
                                                d="M12.12 10.38C12.6133 10.58 13.0333 10.8267 13.38 11.12C13.8333 11.5067 14.06 11.9867 14.06 12.56V14.38C14.0467 14.6467 13.9533 14.8733 13.78 15.06C13.62 15.2467 13.4 15.3533 13.12 15.38C12.84 15.42 12.4067 15.4333 11.82 15.42H2.24C1.96 15.42 1.73333 15.3733 1.56 15.28C1.18667 15.0667 1 14.7667 1 14.38V13.78C1.01333 13.26 1.01333 12.8667 1 12.6C0.986667 12.0267 1.22 11.5267 1.7 11.1C2.11333 10.7533 2.62667 10.4733 3.24 10.26C3.61333 10.1133 4.17333 9.86667 4.92 9.52L5.62 9.2C5.71333 9.14667 5.77333 9.06 5.8 8.94C5.82667 8.56667 5.85333 8.28667 5.88 8.1C5.89333 8.04667 5.87333 7.98 5.82 7.9C5.35333 7.43333 5.04 6.88667 4.88 6.26C4.84 6.16667 4.78 6.12 4.7 6.12C4.51333 6.09333 4.4 5.98667 4.36 5.8L4.2 4.84C4.16 4.62667 4.23333 4.48 4.42 4.4C4.48667 4.36 4.51333 4.30667 4.5 4.24C4.40667 3.73333 4.43333 3.20667 4.58 2.66C4.71333 2.16667 4.96 1.74667 5.32 1.4C5.69333 1.05333 6.1 0.873333 6.54 0.86H6.74C6.95333 0.846666 7.10667 0.813333 7.2 0.76C7.58667 0.559999 7.98 0.526666 8.38 0.66C9.5 1.03333 10.2133 1.76667 10.52 2.86C10.5733 3.06 10.5933 3.28 10.58 3.52C10.58 3.68 10.56 3.90667 10.52 4.2V4.22C10.5067 4.27333 10.5 4.31333 10.5 4.34C10.5133 4.36667 10.5533 4.38667 10.62 4.4C10.82 4.46667 10.9 4.6 10.86 4.8L10.7 5.8C10.66 6.01333 10.54 6.12 10.34 6.12C10.26 6.12 10.2067 6.16 10.18 6.24C10.1 6.78667 9.80667 7.31333 9.3 7.82C9.19333 7.9 9.15333 8.02 9.18 8.18C9.22 8.39333 9.24 8.62 9.24 8.86C9.25333 9.03333 9.33333 9.14667 9.48 9.2C10.5467 9.70667 11.4267 10.1 12.12 10.38ZM21 12.62V14.58C21 14.8067 20.9267 14.9933 20.78 15.14C20.6333 15.2867 20.4533 15.3667 20.24 15.38C19.9867 15.3933 19.62 15.4 19.14 15.4H14.68C14.6 15.4 14.5267 15.3933 14.46 15.38C14.5933 15.1933 14.6867 14.9733 14.74 14.72C14.7667 14.56 14.78 14.3333 14.78 14.04C14.7667 13.52 14.7667 13.0067 14.78 12.5C14.78 11.8867 14.5733 11.3533 14.16 10.9C14.1067 10.8333 14.08 10.7867 14.08 10.76C14.0933 10.72 14.14 10.6867 14.22 10.66C14.38 10.62 14.4733 10.5067 14.5 10.32V10.16C14.5267 10.0133 14.5267 9.92667 14.5 9.9C14.4733 9.87333 14.38 9.85333 14.22 9.84C13.38 9.81333 12.6467 9.64 12.02 9.32C11.9 9.25333 11.7867 9.18 11.68 9.1L11.78 9.02C11.9933 8.84667 12.1467 8.70667 12.24 8.6C12.3867 8.42667 12.5 8.20667 12.58 7.94C12.6333 7.78 12.6867 7.53333 12.74 7.2C12.78 7.01333 12.8067 6.71333 12.82 6.3L12.84 5.76C12.8933 5.12 13.0067 4.60667 13.18 4.22C13.5667 3.34 14.26 2.86 15.26 2.78C15.6467 2.72667 15.9533 2.74 16.18 2.82C16.38 2.87333 16.5067 2.96 16.56 3.08C16.6 3.17333 16.6467 3.23333 16.7 3.26C16.7667 3.27333 16.8533 3.28 16.96 3.28C17.5067 3.32 17.9 3.59333 18.14 4.1C18.3267 4.46 18.42 4.86 18.42 5.3C18.4333 5.46 18.44 5.7 18.44 6.02C18.44 6.32667 18.44 6.56 18.44 6.72C18.4933 7.48 18.7933 8.18667 19.34 8.84C19.4467 8.96 19.4933 9.04 19.48 9.08C19.48 9.12 19.4067 9.16667 19.26 9.22L19.24 9.24C18.52 9.58667 17.7867 9.78 17.04 9.82C16.9733 9.83333 16.9267 9.85333 16.9 9.88C16.8867 9.89333 16.8867 9.93333 16.9 10C16.9133 10.0533 16.92 10.1333 16.92 10.24C16.92 10.48 17.04 10.64 17.28 10.72C17.72 10.8533 18.3933 11.0267 19.3 11.24L19.52 11.3C19.9067 11.4067 20.2067 11.52 20.42 11.64C20.7933 11.8667 20.9867 12.1933 21 12.62Z"
                                                fill="#273958" />
                                        </svg>

                                    </div>
                                </div>
                                <div class="input-item s2">
                                    <a href="{{ route('hotels') }}" class="theme-btn-s2">search hotel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of hero -->

    <!-- start of popular-places-->
    <section class="popular-places-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-12">
                    <div class="wpo-section-title">
                        <span>// Top Destinations</span>
                        <h2>Discover more popular places here.</h2>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="popular-slider owl-carousel">
                        <div class="places-item">
                            <div class="image">
                                <img src="images/popular-places/A.jpg" alt="">
                            </div>
                            <div class="content">
                                <h2>
                                    <a href="places-single.html">Galle</a>
                                </h2>
                                <span>806 places</span>
                            </div>
                        </div>
                        <div class="places-item">
                            <div class="image">
                                <img src="images/popular-places/2.jpg" alt="">
                            </div>
                            <div class="content">
                                <h2>
                                    <a href="places-single.html">Kandy</a>
                                </h2>
                                <span>220 places</span>
                            </div>
                        </div>
                        <div class="places-item">
                            <div class="image">
                                <img src="images/popular-places/3.jpg" alt="">
                            </div>
                            <div class="content">
                                <h2>
                                    <a href="places-single.html">Colombo</a>
                                </h2>
                                <span>648 places</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of popular-places-->

    <!-- start of features-->
    <section class="service-section-s2 section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="wpo-section-title s2  wow fadeInUp" data-wow-duration="1200ms">
                        <span>// Why Choose Us</span>
                        <h2>Some of the reasons why choose Click2Checkin.</h2>
                    </div>
                </div>
            </div>
            <div class="service-wraper">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1100ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-1.svg" alt="" class="active">
                                    <img src="images/features/1.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">Luxurious Suites</a></h2>
                                <span>Stay in modern, elegant rooms designed for comfort and relaxation.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1200ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-2.svg" alt="" class="active">
                                    <img src="images/features/2.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">24/7 Reception</a></h2>
                                <span>Our support team is available anytime to assist with your needs.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1300ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-3.svg" alt="" class="active">
                                    <img src="images/features/3.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">Free High-Speed Wi-Fi</a></h2>
                                <span>Enjoy fast and reliable internet access during your stay.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1400ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-4.svg" alt="" class="active">
                                    <img src="images/features/4.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">Fitness Center</a></h2>
                                <span>Stay active with fully equipped gyms available at many hotels.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1500ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-5.svg" alt="" class="active">
                                    <img src="images/features/5.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">Childcare Services</a></h2>
                                <span>Safe and friendly childcare options for families with young children.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="service-card wow fadeInUp" data-wow-duration="1600ms">
                            <div class="left">
                                <div class="image">
                                    <img src="images/features/img-6.svg" alt="" class="active">
                                    <img src="images/features/6.svg" alt="" class="hover">
                                </div>
                            </div>
                            <div class="right">
                                <h2><a href="service-single.html">Airport Shuttle</a></h2>
                                <span>Easy and convenient transportation to and from the airport.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of features-->

    <!-- start of places-videos-->
    <section class="places-videos-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 order-xl-2  col-12">
                    <div class="wpo-section-title s2 wow fadeInRightSlow" data-wow-duration="1700ms">
                        <span>// hotel highlights</span>
                        <h2>Discover Stunning Hotels & Destinations Through Video Tours.</h2>
                    </div>
                </div>
                <div class="col-xl-7 order-xl-1 col-12">
                    <div class="videos-wraper videos-slide wow fadeInLeftSlow" data-wow-duration="1700ms">
                        <div class="top-slide">
                            <div class="item">
                                <div class="image">
                                    <img src="images/places-videos/1.jpg" alt="">
                                    <div class="video-holder">
                                        <a href="https://youtu.be/VPIfjLqUfxE?si=1CLt6Jnz3Sgthls0" class="video-btn"
                                            data-type="iframe">
                                            <div class="icon">
                                                <svg width="12" height="14" viewBox="0 0 12 14" fill="none">
                                                    <path d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
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
                                                    <path d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
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
                                                    <path d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
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
                                                    <path d="M12 7L-6.52533e-07 13.9282L-4.68497e-08 0.0717964L12 7Z"
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

    <!-- start of featured-->
    <section class="featured-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="wpo-section-title s2">
                        <span>// featured hotels</span>
                        <h2>Discover the Sri Lanka's Most Captivating Featured Places</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-12 sortable-gallery">
                    <div class="gallery-filters">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-12">
                                <ul class="category-item">
                                    <li>
                                        <a data-filter=".new_york" href="#" class="featured-btn ">
                                            Colombo
                                        </a>
                                    </li>
                                    <li>
                                        <a data-filter=".all" href="#" class="featured-btn current">
                                            Galle
                                        </a>
                                    </li>
                                    <li>
                                        <a data-filter=".london" href="#" class="featured-btn">
                                            Kandy
                                        </a>
                                    </li>
                                    <li>
                                        <a data-filter=".tokyo" href="#" class="featured-btn">
                                            Nuwara Eliya
                                        </a>
                                    </li>
                                    <li>
                                        <a data-filter=".paris" href="#" class="featured-btn">
                                            Jaffna
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $limitedHotels = $hotels->take(8);
            @endphp
            <div class="gallery-container gallery-fancybox masonry-gallery row">
                @forelse ($limitedHotels as $hotel)
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
                    <div>No Hotels Listed At This Moment</div>
                @endforelse
            </div>

            @if (count($hotels) > 0)
                <div class="featured-all-btn">
                    <a href="{{ route('hotels') }}" class="theme-btn-s2">view all hotels</a>
                </div>
            @endif

        </div>
    </section>
    <!-- end of featured-->

    <!-- start of authorlist
    <section class="authorlist-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4 col-12">
                    <div class="wpo-section-title s2 wow fadeInLeftSlow" data-wow-duration="1700ms">
                        <span>// author list</span>
                        <h2>Discover the Talented Authors in Our Click2Checkin.</h2>
                        <a href="{{ route('about-us') }}" class="theme-btn">list your property</a>
                    </div>
                </div>
                <div class="col-xl-8 col-12">
                    <div class="authorlist-wrap wow fadeInRightSlow" data-wow-duration="1700ms">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/1.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Esther Howard</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/2.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Jenny Wilson</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/3.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Kristin Watson</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/4.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Bessie Cooper</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/5.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Darlene Robertson</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="auth-card">
                                    <div class="shape">
                                        <svg viewBox="0 0 250 246" fill="none">
                                            <path
                                                d="M0 90.5622C0 85.4392 3.25219 80.8812 8.09651 79.2148L234.097 1.47079C241.887 -1.2093 250 4.57911 250 12.8182V234C250 240.627 244.627 246 238 246H12C5.37258 246 0 240.627 0 234V90.5622Z" />
                                        </svg>
                                    </div>
                                    <div class="image">
                                        <img src="images/authorlist/6.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="rating">
                                            Rating: 4.8 (<img src="images/authorlist/star.svg" alt="">)
                                        </div>
                                        <h2>Marvin McKinney</h2>
                                        <h4>Singapore</h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of authorlist-->

    <!-- start of testimonial -->
    <section class="testimonial-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <div class="wpo-section-title wow fadeInUp" data-wow-duration="1200ms">
                        <span>// customer testimonials</span>
                        <h2>Happy Guests Sharing Their Click2Checkin Experiences</h2>
                    </div>
                </div>
            </div>
            <div class="testimonial-slider owl-carousel">
                <div class="testimonial-card wow fadeInUp" data-wow-duration="1400ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/nadeesha.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Nadeesha Fernando</h3>
                            <span>Frequent Traveler</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“Booking with Click2Checkin was seamless! I found perfect hotels at great prices and enjoyed
                            smooth check-in experiences everywhere.”</p>
                    </div>
                </div>
                <div class="testimonial-card wow fadeInUp" data-wow-duration="1600ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/amal.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Amal Perera</h3>
                            <span>Business Traveler</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“I love how easy it is to compare hotels and book instantly through Click2Checkin. Their 24/7
                            support helped me during a last-minute change.”</p>
                    </div>
                </div>
                <div class="testimonial-card wow fadeInUp" data-wow-duration="1800ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/kavindi.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Kavindi Silva</h3>
                            <span>Vacation Planner</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“Click2Checkin made planning my family trip effortless. The hotel options were excellent, and the
                            booking process was fast and reliable.”</p>
                    </div>
                </div>
                <div class="testimonial-card wow fadeInUp" data-wow-duration="2000ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/ruwan.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Ruwan Jayasuriya</h3>
                            <span>Holidaymaker</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“Thanks to Click2Checkin, I discovered amazing hotels in Sri Lanka I never knew about. The
                            booking experience was quick and easy.”</p>
                    </div>
                </div>
                <div class="testimonial-card wow fadeInUp" data-wow-duration="2200ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/ishani.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Ishani Wijesinghe</h3>
                            <span>Solo Traveler</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“I felt safe booking with Click2Checkin because of their excellent customer service and reliable
                            hotel options throughout Sri Lanka.”</p>
                    </div>
                </div>
                <div class="testimonial-card wow fadeInUp" data-wow-duration="2400ms">
                    <div class="top-content">
                        <div class="image">
                            <img src="{{ Vite::asset('resources/images/image/sameera.jpg') }}" alt="Customer">
                        </div>
                        <div class="text">
                            <h3>Sameera Rajapaksa</h3>
                            <span>Adventure Seeker</span>
                        </div>
                    </div>
                    <div class="content">
                        <p>“Click2Checkin helped me find great hotels close to adventure spots. Booking was hassle-free, and
                            the support team was very helpful.”</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of testimonial -->


    <!-- start of places
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

    <!-- start of blog
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
