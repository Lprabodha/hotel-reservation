@php
    $isAdminRoute = request()->is('admin*');
@endphp

<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ url()->current() }}" class="sidebar-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="/admin" class="d-flex align-items-center gap-2">
                    <iconify-icon icon="mage:dashboard-check-fill" width="25" height="25"></iconify-icon>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>

            @if ($isAdminRoute)


                @if (!auth()->user()->hasRole('hotel-manager'))
                    <li>
                        <a href="{{ route('admin.reservation.index') }}" class="d-flex align-items-center gap-2">
                            <iconify-icon icon="tabler:brand-booking" width="25" height="25"></iconify-icon>
                            <span class="ms-2">Reservation</span>
                        </a>
                    </li>

                    @if (auth()->user()->hasRole('hotel-clerk'))
                        <li>
                            <a href="{{ route('admin.reservation.create') }}" class="d-flex align-items-center gap-2">
                                <iconify-icon icon="tabler:brand-booking" width="25" height="25"></iconify-icon>
                                <span class="ms-2">Reservation Request</span>
                            </a>
                        </li>
                    @endif

                @endif

                @if (auth()->user()->hasRole('hotel-clerk') || auth()->user()->hasRole('hotel-manager'))
                    <li>
                        <a href="{{ route('admin.customers.index') }}" class="d-flex align-items-center gap-2">
                            <iconify-icon icon="ix:customer-filled" width="25" height="25"></iconify-icon>
                            <span class="ms-2">Customers</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('super-admin'))
                    <li>
                        <a href="{{ route('admin.hotels') }}" class="d-flex align-items-center gap-2">
                            <iconify-icon icon="fa6-solid:hotel" width="25" height="25"></iconify-icon>
                            <span class="ms-2">Hotels</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.rooms.index') }}" class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:guest-room" width="25" height="25"></iconify-icon>
                            <span class="ms-2">Rooms</span>
                        </a>
                    </li>
                @endif


                @if (auth()->user()->hasRole('super-admin'))
                    <li>
                        <a href="{{ route('admin.payments.index') }}" class="d-flex align-items-center gap-2">
                            <iconify-icon icon="tdesign:money" width="25" height="25"></iconify-icon>
                            <span class="ms-2">Payments</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole('hotel-manager'))
                    <li class="dropdown">
                        <a href="javascript:void(0)">
                            <iconify-icon icon="mdi:file-report-outline" class="menu-icon"></iconify-icon>
                            <span>Reports</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.reports.index') }}">
                                    <iconify-icon icon="carbon:summary-kpi" class="menu-icon"></iconify-icon>
                                    Summary & Reservation</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.reports.payments') }}">
                                    <iconify-icon icon="material-symbols:payments" class="menu-icon"></iconify-icon>
                                    Payments</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->hasRole('super-admin'))
                    <li class="dropdown">
                        <a href="javascript:void(0)">
                            <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                            <span>Users Management</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.users.index') }}"><i
                                        class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                    Customers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.managers.index') }}"><i
                                        class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                                    Hotel Managers</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.hotel-clerks.index') }}"><i
                                        class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                                    Hotel Clerks</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.travel-companies.index') }}"><i
                                        class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                                    Travel Companies</a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</aside>
