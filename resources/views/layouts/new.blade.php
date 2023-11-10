@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp

<!doctype html>
<html lang="en">

<!-- Mirrored from preview.pichforest.com/dashonic/layouts// by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Oct 2023 12:50:10 GMT -->

<head>

    <meta charset="utf-8" />
    <title>{{ $department->department_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Pichforest" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">

    <!-- plugin css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    @yield('head')

    <!-- Khmer Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Siemreap&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Preahvihear&display=swap" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Preahvihear&display=swap');

        * {
            font-family: 'Siemreap', sans-serif;
        }

        .navbar-nav .nav-link i {
            color: grey;
        }

        .navbar-nav .nav-link.active i {
            color: blue;
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".nav-link").each(function() {
                if ($(this).attr("href") == window.location.pathname) {
                    $(this).addClass("active");
                }
            });
        });
    </script>

</head>

<body data-layout="horizontal" style="min-height: 100vh; background-color: #E5E5E5;">
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header py-5">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box mx-0 pe-2">
                        <a href="/officer" class="logo logo-dark">
                            <h5 class="logo-sm py-3">
                                <img src="/logo.png" alt="" height="55">
                            </h5>
                            <h5 class="logo-lg py-3">
                                <img src="/logo.png" alt="" height="75">
                            </h5>

                        </a>

                        <a href="/officer" class="logo logo-light">
                            <h5 class="logo-sm py-3">
                                <img src="/logo.png" alt="" height="55">
                            </h5>
                            <h5 class="logo-lg py-3">
                                <img src="/logo.png" alt="" height="75">
                            </h5>
                        </a>

                    </div>

                    <p style="line-height: 2; font-family: 'Moul', cursive;font-size:16px; margin: auto 0; color:#e5a025;"
                        class=" fw-bold">
                        គណៈកម្មការ​ចំពោះ​កិច្ច​ត្រួត​ពិនិត្យនិង​ដោះស្រាយបញ្ហា​ដំណើរ​ចេញ​​ចូល​<br>​របស់​ពលករ​ខ្មែរ​តាម​ព្រំ​ដែន​នៃ​ព្រះរាជាណាចក្រកម្ពុជា​
                    </p>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item my-auto"
                        data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>


                </div>

                <div class="dropdown d-inline-block">
                    <div class="my-auto d-flex py-1">
                        <h5 class="my-auto text-primary fw-bold">{{ Auth::user()->fullname }}</h5>
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('changeCredential') }}">កែប្រែព័ត៍មាន</a></li>
                        </ul>
                        <h5 class="my-auto px-2">|</h5>

                        <a href="{{ route('logout') }}" class="my-auto text-decoration-none text-primary px-0"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <h5 class="my-0"><strong>ចាកចេញពីគណនី</strong></h5>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <h6 class="my-auto text-danger py-1"><strong>{{ $department->department_name }}</strong></h6>

                </div>

            </div>
            <div class="topnav" style="background-color: #F5F5F5E0 !important">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li>
                                    <a class="nav-link d-flex" href="/">
                                        <i class="fa fa-home my-1 me-1" aria-hidden="true"></i>
                                        <h5 class="text-primary my-0 font"><strong class="font">គេហទំព័រដើម</strong>
                                        </h5>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link d-flex" href="/cases">
                                        <i class="fa fa-list me-2 my-1"></i>
                                        <h5 class="text-primary my-0 font "><strong
                                                class="font">របាយការណ៍</strong>
                                        </h5>
                                    </a>
                                </li>

                                <li>
                                    <a class="nav-link d-flex" href="/report">
                                        <i class="fa fa-table me-2 my-1"></i>
                                        <h5 class="text-primary my-0 font "><strong class="font">ទិន្នន័យសង្ខេប</strong>
                                        </h5>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
    </div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>

<style>
    * {

        font-family: 'Siemreap', sans-serif;
    }

    .font {
        font-family: 'Preahvihear', sans-serif;
    }
</style>
