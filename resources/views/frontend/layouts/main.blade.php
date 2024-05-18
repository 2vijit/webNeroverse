<!doctype html>
<html>
@include('frontend.layouts.partials.header')

<body>

    <!-- Header -->
    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('public/frontend/assets/img/neoroverseLogo.png') }}" />
            </a>

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
            <!-- .navbar -->
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>

                    <li><a href="{{ route('service') }}">Services</a></li>
                    <li><a href="{{ route('casestudy') }}" class="active">Case Study</a></li>
                    <li><a href="{{ route('login') }}" class="active">Login</a></li>
                </ul>
            </nav>
            <li class="navbar">
                <a class="get-a-quote" href="get-a-quote.html">
                    <span> Contact Us </span>
                </a>
            </li>
            <!-- .navbar -->
        </div>
    </header>
    @yield('main.content')

    <!--====== footer start ======-->
    @include('frontend.layouts.partials.footer')
    <!--====== footer end ======-->
    {{-- @include('layouts.partials.cart') --}}
    <!-- JS here -->

    @include('frontend.layouts.partials.scripts')


</body>

</html>
