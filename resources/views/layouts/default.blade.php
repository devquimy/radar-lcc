<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="BMA">
    <meta name="robots" content="noindex, nofollow">

    <title>Radar LCC</title>
    <link rel="icon" href="{{ asset('/img/favicon.jpeg') }}">

    @hasSection('content-auth')
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/flash.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @endif

    @hasSection('content')
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/all.css') }}"> 
        <link rel="stylesheet" href="{{ asset('/css/login.css') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <style type="text/css">
        /* Chart.js */
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }

            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor,
        .chartjs-size-monitor-expand,
        .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand>div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink>div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }
    </style>
</head>

{{-- Seção logada --}}
@hasSection('content-auth')
    <body id="page-top">
        <div id="wrapper">
            <style>
                .flash-message{ 
                    background-color: #0074d9d9 !important;
                    color: white!important;
                    font-weight: bold;
                    box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
                }
                .flash-progress{
                    background-color: white!important;
                }
                .flash-container .flash-message.flash-info:after{
                    color: white!important
                }
            </style>
            {{-- Menu --}}
            @include("layouts.menu")

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    {{-- NavBar --}}
                    @include('layouts.navbar')

                    {{-- Flash message --}}
                    @include('layouts.flash-message')

                    {{-- Telas --}}
                    @yield('content-auth')
                </div>
                
                {{-- Footer --}}
                @include('layouts.footer')
            </div>
        </div>
    </body>
@endif

{{-- Seção não logada --}}
@hasSection('content')    
    @yield('content')
    @include('layouts.footer')
@endif

</html>

