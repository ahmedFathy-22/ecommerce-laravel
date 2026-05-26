<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials.head')

</head>

<body>

    @include('layouts.partials.loader')
    
    @include('layouts.partials.topbar')

    @include('layouts.partials.navbar')

    @include('layouts.partials.search')

    @include('layouts.partials.alerts')

    @if(request()->routeIs('home'))
        @include('layouts.partials.hero')
    @endif

    @yield('content')

    @include('layouts.partials.footer')

    @include('layouts.partials.scripts')

</body>
</html>
