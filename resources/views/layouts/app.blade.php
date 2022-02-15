<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">


    @livewireStyles
</head>
<body>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
    
<header class="ptb-50">
    <div class="header-bottom wrapper-padding-2 res-header-sm sticker header-sticky-3 furits-header">
        <div class="container-fluid">
            <div class="header-bottom-wrapper ">
                <div class="logo-2 ptb-35 menu-hover">
                    <a href="{{route('home')}}">
                        <img style="width: 150px" src="{{asset('img/logo.png')}}" alt="">
                    </a>
                </div>
                <div class="menu-style-2 handicraft-menu menu-hover">
                    <nav>
                        <ul>
                            <li><a href="{{route('home')}}">Home</a></li>
                            <li>
                                <a href="{{ route('shop.index') }}">
                                    Products
                                </a>
                            </li>
                            <ul class="single-dropdown">
                                <li>
                                    <a href="">Contact us</a>
                                </li>
                                @guest
                                    <li>
                                        <a href="{{route('login')}}">Login</a>
                                    </li>
                                    @if (route('register'))
                                        <li>
                                            <a href="{{route('register')}}">Register</a>
                                        </li>
                                    @endif
                                @endguest
                                <li>
                                    <a href="">Cart page</a>
                                </li>
                            </ul>
                            <li>
                                <a href="javascript:void(0);">Categories</a>
                                <ul class="single-dropdown" style="top: 100px;">
                                    @forelse($categories_menu as $category)
                                        <li>
                                            <a href="{{ route('shop.index', $category->slug) }}">{{ $category->name }}</a>
                                        </li>
                                    @empty
                                        <li>
                                            No categories found !
                                        </li>
                                    @endforelse
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">Pages</a>
                                <ul class="single-dropdown" style="top: 100px;">
                                </ul>
                            </li>
                            <li>
                                <a href="">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="furits-login-cart">
                    <div class="furits-login menu-hover">
                        <ul>
                            @guest
                                <li><a href="{{route('login')}}">Login</a></li>
                                <li><a href="{{route('register')}}">Reg</a></li>
                            @else
                                <li>
                                </li>

                                <li>
                                    <a href="javascript:void(0);" style="color: #578a01;">My Account</a>
                                    <ul class="single-dropdown">
                                        <li>
                                            <a href="" style="color: #578a01;">
                                                Administration
                                            </a>
                                        @auth
                                            <li><a href="" style="color: #578a01;">Dashboard</a>
                                            </li>
                                        @endauth
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #578a01;">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                    <livewire:frontend.header.cart-component />
                </div>
            </div>
            <div class="row">
                <div class="mobile-menu-area d-md-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul class="menu-overflow">
                                <li><a href="">HOME</a></li>
                                <li><a href="">PRODUCTS</a></li>
                                <li><a href="#">Categories</a>
                                    <ul>
                                    <li><a href="#">sdmks</a></li>
                                    </ul>
                                </li>
                                <li><a href="">contact</a></li>
                                @guest
                                    <li>
                                        <a href="{{route('login')}}">Login</a>
                                    </li>
                                    <li>
                                        <a href="{{route('register')}}">Reg</a>
                                    </li>
                                @else
                                        <li><a href="">Administration</a>
                                        <li><a href="">Administration</a>
                                    <li><a href="">Dashboard</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="breadcrumb-area pt-50">
    <div class="container-fluid">
        <div class="furniture-bottom-wrapper">
            <div class="furniture-login">
            </div>
            <div class="furniture-search">
                <form>
                    <div class="form-input">
                        <input id="search" type="text"
                               value="{{ old('keyword', request()->keyword) }}"
                               placeholder="Search for product...">
                    </div>
                </form>
            </div>
            <div class="furniture-wishlist">
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
            </div>
        </div>
    </div>
</div>

            @yield('content')

    <footer class="footer-area fruits-footer">
        <div class="food-footer-bottom pt-80 pb-70 black-bg-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget mt-50">
                            <div class="food-about">
                                <p class="footer-widget-title-6">Online Shop</p>
                                <div class="food-about-info">
                                    <div class="food-info-wrapper">
                                        <div class="food-address">
                                            <div class="food-info-icon">
                                                <i class="pe-7s-map-marker"></i>
                                            </div>
                                            <div class="food-info-content">
                                                <p>Website address here</p>
                                            </div>
                                        </div>
                                        <div class="food-address">
                                            <div class="food-info-icon">
                                                <i class="pe-7s-call"></i>
                                            </div>
                                            <div class="food-info-content">
                                                <p>+966 000-000000</p>
                                            </div>
                                        </div>
                                        <div class="food-address">
                                            <div class="food-info-icon">
                                                <i class="pe-7s-chat"></i>
                                            </div>
                                            <div class="food-info-content">
                                                <p>
                                                    <a href="https://alijumaan.com">alila3883@gmail.com</a> <br>
                                                    <a href="https://alijumaan.com" target="_blank">contact@alijumaan.com</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget mt-50">
                            <h3 class="footer-widget-title-6">Options</h3>
                            <div class="food-widget-content">
                                <ul>
                                    <li><a href=""><img
                                                src="{{ asset('frontend/img/icon-img/41.png') }}" alt="hhhhhh"> Cart</a></li>
                                    <li>
                                        <a href=""><img src="{{ asset('frontend/img/icon-img/41.png') }}" alt="">
                                            My Account</a>
                                    </li>
                                    @guest
                                        @if (route('register'))
                                            <li>
                                                <a href="{{ route('register') }}">
                                                    <img src="{{ asset('frontend/img/icon-img/41.png') }}" alt="">
                                                    Register
                                                </a>
                                            </li>
                                        @endif
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget mt-50">
                            <h3 class="footer-widget-title-6">Information</h3>
                            <div class="food-widget-content">
                                <ul>
                                    <li>
                                        <a href="">
                                            <img src="{{ asset('frontend/img/icon-img/41.png') }}" alt="">
                                            About
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <img src="{{ asset('frontend/img/icon-img/41.png') }}" alt="">
                                            Contact
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <img src="{{ asset('frontend/img/icon-img/41.png') }}" alt="">
                                            Privacy Policy
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle black-bg-2 pt-35 pb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="footer-services-wrapper mb-30">
                            <div class="footer-services-icon">
                                <i class="pe-7s-car"></i>
                            </div>
                            <div class="footer-services-content">
                                <h3>Free Shipping</h3>
                                <p>Free Shipping on Bangladesh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="footer-services-wrapper mb-30">
                            <div class="footer-services-icon">
                                <i class="pe-7s-shield"></i>
                            </div>
                            <div class="footer-services-content">
                                <h3>Money Guarentee</h3>
                                <p>Free Shipping on Bangladesh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="footer-services-wrapper mb-30">
                            <div class="footer-services-icon">
                                <i class="pe-7s-headphones"></i>
                            </div>
                            <div class="footer-services-content">
                                <h3>Online Support</h3>
                                <p>Free Shipping on Bangladesh</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <img src="{{ asset('frontend/img/icon-img/3.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="food-copyright black-bg-6 ptb-30">
            <div class="container text-center">
                <p class="copyright text-center">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    Created by
                    <a href="https://alialqahtani.sa" target="_blank" class="text-primary">alialqahtani.sa</a>
                </p>
            </div>
        </div>
    </footer>


    
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src="{{ asset('frontend/js/vendor/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ajax-mail.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/alert-message.js') }}"></script>
    <script src="{{ url('https://kit.fontawesome.com/8003f9e0e2.js') }}" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
   
    <script>
        $(document).ready(function() {
            let bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{url("search")}}?productName=%QUERY%', //'/user/find?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
            });

            $('#search').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'products',
                source: bloodhound,
                limit: 10,
                display: function(data) {
                    return data.name  //Input value to be set when you select a suggestion.
                },
                templates: {
                    empty: [
                        '<div class="list-group-item">There are no matching search results</div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function(data) {
                        return '<div style="font-weight:normal; width:100%" class="list-group-item"><a href="{{url('product')}}/'+data.slug+'">' + data.name + '</a></div></div>'
                    }
                }
            });
        });
    </script>
    @livewireScripts
</body>
</html>
