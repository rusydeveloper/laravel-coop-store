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

    <script type="text/javascript">
        $(document).ready(function() {
  $('.summernote').summernote();
});
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-148001077-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-148001077-1');
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

        .sidenav {
            height: 100%;
            width: 0px;
            position: fixed;
            z-index: 99;
            top: 0;
            left: 0;
            background-color: #0074b7;
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

            font-size: 12pt;
            /* Increased text to enable scrolling */
            padding: 0px 10px;
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

        .input-search {
            width: 100%;
            font-size: 14px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        .table-head-sort:hover {
            cursor: pointer;
            background-color: orange
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
        }

        .flex-container>div {
            margin: 5px;
            text-align: center;
        }

        .text-red {
            color: red
        }
    </style>
</head>

<body>
    <div id="app">
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
            <a href="{{route('admin_user')}}"><span class="fa fa-user"></span> Pengguna</a>
            <a href="{{route('admin_business')}}"><span class="fa fa-briefcase"></span> Perusahaan</a>
            <a href="{{route('admin_invoice_discount')}}"><span class="fa fa-percent"></span> Diskon</a>
            <a href="{{route('admin_category')}}"><span class="fa fa-circle-o"></span> Kategori</a>
            <a href="{{route('admin_product')}}"><span class="fa fa-cubes"></span> Produk</a>
            <a href="{{route('admin_campaign')}}"><span class="fa fa-tasks"></span> Campaign</a>
            <a href="{{route('admin_order')}}"><span class="fa fa-shopping-basket"></span> Pesanan</a>
            <a href="{{route('admin_invoice')}}"><span class="fa fa-clone"></span> Tagihan</a>
            <a href="{{route('admin_payment')}}"><span class="fa fa-credit-card"></span> Pembayaran</a>
            <a href="{{route('admin_wallet')}}"><span class="fa fa-money"></span> Dompet</a>
            <a href="{{route('admin_report')}}"><span class="fa fa-pie-chart"></span> Laporan</a>
        </div>

        <main class="py-4 main">
            <a href="{{url()->previous()}}"><button class="btn btn-lg btn-secondary">Back</button></a> @yield('content')
        </main>
    </div>
    <script>
        //         function openNav() {
//   document.getElementById("mySidenav").style.width = "180px";
// }

// function closeNav() {
//   document.getElementById("mySidenav").style.width = "0";
// }

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.body.style.backgroundColor = "white";
}
    </script>
</body>

</html>