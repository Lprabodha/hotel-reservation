<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ Vite::asset('resources/images/admin/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="/admin" class="d-flex align-items-center">
                    <iconify-icon icon="mage:dashboard-check-fill" width="25" height="25"></iconify-icon>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.hotels') }}" class="d-flex align-items-center">
                    <iconify-icon icon="emojione-monotone:hotel" width="25" height="25"></iconify-icon>
                    <span class="ms-2">Hotels</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rooms') }}" class="d-flex align-items-center">
                    <iconify-icon icon="cbi:roomsother" width="25" height="25"></iconify-icon>
                    <span class="ms-2">Rooms</span>
                </a>
            </li>

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
                        <a href="{{route('admin.managers.index')}}"><i class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                            Hotel Managers</a>
                    </li>
                    <li>
                        <a href="{{route('admin.hotel-clerks.index')}}"><i class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                            Hotel Clerks</a>
                    </li>
                    <li>
                        <a href="add-user.html"><i class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                            Travel Companies</a>
                    </li>
                    <li>
                        <a href="add-user.html"><i class="ri-circle-fill circle-icon text-primary-main w-auto"></i>
                            User Permissions</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.role.index') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            User Roles</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</aside>
