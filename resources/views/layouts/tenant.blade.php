<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nectico</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('plugins/summernote/summernote.js') }}"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148001077-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-148001077-1');
    </script>



    <script type="text/javascript">
        $(document).ready(function() {
  $('.summernote').summernote();
});
    </script>

    <!-- Fonts -->


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('plugins/summernote/summernote.css') }}" rel="stylesheet">


    <style type="text/css">
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .sidenav {
            height: 100%;
            width: 0px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #4A959C;
            overflow-x: hidden;
            padding-top: 30px;

        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            transition: 0.3s;

        }

        .sidenav a:hover {
            color: #FFB419;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }


        .main {
            /* Same as the width of the sidenav */
            font-size: 14px;
            /* Increased text to enable scrolling */
            padding: 0px 5px;
        }

        .btn-space {
            margin-left: 5px;
            margin-right: 5px;
            padding-left: 10px;
            padding-right: 10px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

    <div id="main">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/img/logo/logo-nectico.png') }}" height="30px" style="margin-left: 10px"
                        id="logo-navbar">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="{{route('tenant')}}"><span class="fa fa-shopping-basket"></span> Utama</a>
            <a href="{{route('tenant_invoice')}}"><span class="fa fa-file-text-o"></span> Pesanan</a>
            <a href="{{route('tenant_report')}}"><span class="fa fa-pie-chart"></span> Laporan</a>
            <a href="{{route('tenant_card_index')}}"><span class="fa fa-qrcode"></span> Scan</a>
        </div>
        <main class="py-4 main">
            @yield('content')
        </main>
    </div>
    <script>
        function openNav() {
  document.getElementById("mySidenav").style.width = "180px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
    </script>
</body>

</html>