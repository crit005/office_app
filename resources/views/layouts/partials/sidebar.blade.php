<aside class="main-sidebar sidebar-dark-primary elevation-2 blur-sidebar">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @auth
                    <img src="{{ auth()->user()->photoUrl }}" class="img-circle elevation-2"
                        style="width: 34px; height: 34px;" alt="User Image">
                @endauth
                @guest
                    <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="User Image">
                @endguest
            </div>
            <div class="info">
                <a href="#" class="d-block">@auth
                        {{ auth()->user()->name }}
                    @endauth
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                {{-- Dashboar Menu --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                {{-- Customer menu --}}
                <li class="nav-item {{ Request::segment(1) == 'customer' ? 'menu-open' : 'menu-close' }}">
                    {{-- <li class="nav-item menu-open"> --}}
                    <a href="#" class="nav-link {{ Request::segment(1) == 'customer' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p class="red">
                            Customers
                            <i class="right fas fa-angle-down"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        {{-- Depatment Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('customer.list') }}"
                                class="nav-link {{ request()->is('customer/list') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-address-card ml-2"></i>
                                <p>
                                    List Customer
                                </p>
                            </a>
                        </li>

                        {{-- Currency Menu --}}
                        {{-- <li class="nav-item">
                                <a href="{{route('setting.currencies')}}"
                                    class="nav-link {{ request()->is('setting/currencies') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-clock ml-2"></i>
                                    <p>
                                        Customer Detail
                                    </p>
                                </a>
                            </li> --}}
                        {{-- Customer active Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('customer.newmember') }}"
                                class="nav-link {{ request()->is('customer/newmember') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tag ml-2"></i>
                                <p>
                                    New Customers
                                </p>
                            </a>
                        </li>
                        {{-- Customer active Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('customer.active') }}"
                                class="nav-link {{ request()->is('customer/active') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-check ml-2"></i>
                                <p>
                                    Active Customers
                                </p>
                            </a>
                        </li>
                        {{-- Customer active Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('customer.inactive') }}"
                                class="nav-link {{ request()->is('customer/inactive') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-injured ml-2"></i>
                                <p>
                                    Inactive Customers
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Paynebt menu --}}
                @if (auth()->user()->group->name != 'MAKETING')
                {{-- Cash list --}}
                <li class="nav-item">
                    <a href="{{ route('cash.transaction.tr_list') }}"
                        class="nav-link {{ request()->is('cash/transaction/tr_list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Cash Lists
                        </p>
                    </a>
                </li>
                {{-- Passport Menu --}}
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-passport"></i>
                        <p>
                            Passport
                        </p>
                    </a>
                </li>

                {{-- Longleav Menu --}}
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plane-departure"></i>
                        <p>
                            Longleav
                        </p>
                    </a>
                </li>

                {{-- MOto Menu --}}
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-motorcycle"></i>
                        <p>
                            Moto
                        </p>
                    </a>
                </li>
                @endif



                {{-- Setting menu --}}
                <li class="nav-item {{ Request::segment(1) == 'setting' ? 'menu-open' : 'menu-close' }}">
                    {{-- <li class="nav-item menu-open"> --}}
                    <a href="#" class="nav-link {{ Request::segment(1) == 'setting' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p class="red">
                            Setting
                            <i class="right fas fa-angle-down"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @if (auth()->user()->group->name != 'MAKETING')
                        {{-- Depatment Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.depatments') }}"
                                class="nav-link {{ request()->is('setting/depatments') ? 'active' : '' }}">
                                <i class="vav-icon fas fa-sitemap ml-2"></i>
                                <p>
                                    Depatment
                                </p>
                            </a>
                        </li>

                        {{-- Currency Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.currencies') }}"
                                class="nav-link {{ request()->is('setting/currencies') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding-usd ml-2"></i>
                                <p>
                                    Currencies
                                </p>
                            </a>
                        </li>

                        {{-- Item Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.items') }}"
                                class="nav-link {{ request()->is('setting/items') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-dice-d6 ml-2"></i>
                                <p>
                                    Items
                                </p>
                            </a>
                        </li>
                        @endif
                        {{-- User Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.users') }}"
                                class="nav-link {{ request()->is('setting/users') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users ml-2"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>

                        {{-- Profile Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.users') }}"
                                class="nav-link {{ request()->is('setting/profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user ml-2"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>



                {{-- Logout mentu --}}
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </form>

                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
