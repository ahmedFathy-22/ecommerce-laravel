@if (request()->routeIs('home'))
    <div class="homepage-slider"> <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p>ADVANCED SHOPPING EXPERIENCE</p>
                                <h1>Discover Amazing Products</h1>
                                <div class="hero-btns"> <a href="{{ route('categories.index') }}" class="boxed-btn">Browse
                                        Categories</a>
                                    <a href="{{ route('contact') }}" class="bordered-btn">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle">Visit Everyday</p>
                                <h1>100% Organic Collection</h1>
                                <div class="hero-btns"> <a href="{{ route('products.index') }}" class="boxed-btn">Visit Shop</a>
                                    <a href="{{ route('contact') }}" class="bordered-btn">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-right">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle">Mega Sale Going On!</p>
                                <h1>Get December Discount</h1>
                                <div class="hero-btns"> <a href="{{ route('products.index') }}" class="boxed-btn">Visit Shop</a>
                                    <a href="{{ route('contact') }}" class="bordered-btn">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
