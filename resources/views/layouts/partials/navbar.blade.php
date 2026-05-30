<div class="top-header-area" id="sticker">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-sm-12 text-center">

                <div class="main-menu-wrap">

                    <!-- Logo -->
                    <div class="site-logo">

                        <a href="{{ route('home') }}" class="logo-text">

                            Shop<span>Hub</span>

                        </a>

                    </div>

                    <!-- Menu -->
                    <nav class="main-menu">

                        <ul>

                            <li class="current-list-item">

                                <a href="{{ route('home') }}">
                                    Home
                                </a>

                            </li>

                            <li>

                                <a href="{{ route('products.index') }}">
                                    Shop
                                </a>

                            </li>

                            <li>

                                <a href="{{ route('categories.index') }}">
                                    Categories
                                </a>

                            </li>

                            <li>
                                <a href="{{ route('about') }}">About</a>
                            </li>

                            <li>
                                <a href="{{ route('contact') }}">
                                    Contact
                                </a>
                            </li>

                            @if (auth()->check() && auth()->user()->is_admin)
                                <li>

                                    <a href="#">
                                        Admin
                                    </a>

                                    <ul class="sub-menu">

                                        <li>
                                            <a href="{{ route('admin.dashboard') }}">
                                                Dashboard
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('products.create') }}">
                                                Add Product
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('categories.create') }}">
                                                Add Category
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('orders.index') }}">
                                                Orders
                                            </a>
                                        </li>

                                    </ul>

                                </li>
                            @endif

                            @auth

                                <li>
                                    <a href="{{ route('wishlist') }}">
                                        <i class="fas fa-heart"></i> Wishlist
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('my.orders') }}">
                                        <i class="fas fa-box"></i> My Orders
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user"></i> Profile
                                    </a>
                                </li>

                                <li>

                                    <form action="{{ route('logout') }}" method="POST">

                                        @csrf

                                        <button type="submit" class="logout-btn">
                                            Logout
                                        </button>

                                    </form>

                                </li>
                            @else
                                <li>

                                    <a href="{{ route('login') }}">
                                        Login
                                    </a>

                                </li>

                                <li>

                                    <a href="{{ route('register') }}">
                                        Register
                                    </a>

                                </li>

                            @endauth

                            <li>

                                <div class="header-icons">

                                    <a class="shopping-cart" href="{{ route('cart') }}">

                                        <i class="fas fa-shopping-cart"></i>

                                        <span id="cart-count">

                                            {{ array_sum(session('cart', [])) }}

                                        </span>

                                    </a>

                                    <a class="mobile-hide search-bar-icon" href="#">

                                        <i class="fas fa-search"></i>

                                    </a>

                                </div>

                            </li>

                        </ul>

                    </nav>

                    <a class="mobile-show search-bar-icon" href="#">

                        <i class="fas fa-search"></i>

                    </a>

                    <div class="mobile-menu"></div>

                </div>

            </div>

        </div>

    </div>

</div>
