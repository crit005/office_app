<aside class="main-sidebar sidebar-dark-primary elevation-2 blur-sidebar">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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

                {{-- Expand Menu --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('expand') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Expand
                        </p>
                    </a>
                </li>

                {{-- Passport Menu --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-passport"></i>
                        <p>
                            Passport
                        </p>
                    </a>
                </li>

                {{-- Longleav Menu --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plane-departure"></i>
                        <p>
                            Longleav
                        </p>
                    </a>
                </li>

                {{-- MOto Menu --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('cashdrawer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-motorcycle"></i>
                        <p>
                            Moto
                        </p>
                    </a>
                </li>


                {{-- Setting menu --}}
                <li class="nav-item {{ Request::segment(1)=='setting'? 'menu-open' : 'menu-close'}}">
                    <a href="#" class="nav-link {{ Request::segment(1)=='setting'? 'active' : ''}}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p class="red">
                            Setting
                            <i class="right fas fa-angle-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        {{-- Depatment Menu --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('setting/depatment') ? 'active' : '' }}">
                                <i class="vav-icon fas fa-sitemap"></i>
                                <p>
                                    Depatment
                                </p>
                            </a>
                        </li>

                        {{-- Currency Menu --}}
                        <li class="nav-item">
                            <a href="{{route('setting.currencies')}}" class="nav-link {{ request()->is('setting/currencies') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    Currencies
                                </p>
                            </a>
                        </li>

                        {{-- Item Menu --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('setting/items') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-dice-d6"></i>
                                <p>
                                    Items
                                </p>
                            </a>
                        </li>

                        {{-- Cashdrawer --}}
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->is('setting/cashdrawer') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>
                                    Cashdrawer
                                </p>
                            </a>
                        </li>

                        {{-- User Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.users') }}"
                                class="nav-link {{ request()->is('setting/users') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>

                        {{-- Profile Menu --}}
                        <li class="nav-item">
                            <a href="{{ route('setting.users') }}"
                                class="nav-link {{ request()->is('setting/profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
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
