<div class="footer-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">

                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-box get-in-touch">
                            <h2 class="widget-title">Get in Touch</h2>
                            <ul>
                                <li>Kuwait City</li>

                                <li>support@store.com</li>

                                <li>+965 00000000</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-box pages">
                            <h2 class="widget-title">Pages</h2>
                            <ul>

                                <li>
                                    <a href="/">Home</a>
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
                                    <a href="{{ route('cart') }}">
                                        Cart
                                    </a>
                                </li>

                                @auth

                                    <li>
                                        <a href="{{ route('wishlist') }}">
                                            Wishlist
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('my.orders') }}">
                                            My Orders
                                        </a>
                                    </li>

                                @endauth

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">

                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>, All
                            Rights Reserved.<br> Distributed By - <a href="https://themewagon.com/">Themewagon</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
