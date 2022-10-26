<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }} w-100">
                <a class="nav-link" href="/dashboard">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Menu</span>
        </p>

        @can('isAdmin')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item {{ request()->is('users*') || request()->is('jurusan*') || request()->is('angkatan*') ? 'active' : '' }} dropdown">
                <a href="#data-master" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Data Master</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="data-master">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('users.index') }}"><span class="ml-1 item-text">Data User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('products.index') }}"><span class="ml-1 item-text">Data Product</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item {{ request()->is('devices*') || request()->is('rfid*') || request()->is('angkatan*') ? 'active' : '' }} dropdown">
                <a href="#data-device" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-3 item-text">Data Device</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="data-device">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('devices.index') }}"><span class="ml-1 item-text">Data Device</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="{{ route('histories.index') }}"><span class="ml-1 item-text">History Device</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item {{ request()->is('orders') ? 'active' : '' }} w-100">
                <a class="nav-link" href="{{ route('orders.index') }}">
                    <i class="fe fe-shopping-cart fe-16"></i>
                    <span class="ml-3 item-text">List Order</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('isUser')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item {{ request()->is('products*') ? 'active' : '' }} w-100">
                <a class="nav-link" href="{{ route('products.index') }}">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Product</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('my-cart') ? 'active' : '' }} w-100">
                <a class="nav-link" href="{{ route('mycart') }}">
                    <i class="fe fe-shopping-cart fe-16"></i>
                    <span class="ml-3 item-text">My Cart</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('orders') ? 'active' : '' }} w-100">
                <a class="nav-link" href="{{ route('orders.index') }}">
                    <i class="fe fe-shopping-cart fe-16"></i>
                    <span class="ml-3 item-text">My Order</span>
                </a>
            </li>
        </ul>
        @endcan
    </nav>
</aside>