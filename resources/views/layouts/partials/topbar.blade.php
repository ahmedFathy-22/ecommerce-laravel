<div class="top-bar-area">

    <div class="container d-flex justify-content-between">

        <div>
            🚚 Free Shipping On Orders Over 50$
        </div>

        @auth

            <div>
                👋 Welcome, {{ auth()->user()->name }}
            </div>

        @endauth

    </div>

</div>
