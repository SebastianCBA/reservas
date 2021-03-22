<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="app">
<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>    
    
@yield('head')
</head>
<body ng-controller="appController">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.cms', 'Reserva Butacas') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('usuarios') }}" target="_self">Usuarios</a></li>
                        <li><a href="{{ route('reservas') }}" target="_self">Reservas</a></li>                        
                    </ul>

                </div>
            </div>
        </nav>
                @include('flash-message')
                @if(count($errors)>0)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach 
                        </ul>
                    </div>
                @endif  

        @yield('content')
    </div>
@yield('js')
</body>
</html>
