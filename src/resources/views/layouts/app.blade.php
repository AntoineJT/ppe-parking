<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>PPE Parking - @yield('title')</title>
    <meta charset="utf8">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico')}}"/>

    <!-- Style -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="{{ asset('/css/vendor/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css">
    @stack('styles')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Sigmar+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/js/flash-message.js') }}" type="text/javascript"></script>
    @stack('scripts')
</head>
@php
    use \App\Utils\SessionManager;
@endphp
<body class="bg-white text-dark">
<header class="bg-white">
    <div class="container">
        <nav class="navbar shadow-sm p-3 mb-5 navbar-expand-lg navbar-light bg-light rounded mt-4 ">
            <span class="col-7 nav-log font-weight-bold">Parking</span>
            <div class="col-2"></div>
            @if (!SessionManager::isLogged())
                <a class="nav-link nav-item" href="{{ route('home') }}"><i class="fas fa-home mr-2"></i>Accueil</a>
                <a class="nav-link nav-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-2"></i>Connexion</a>
            @elseif (SessionManager::isPersonnel())
                <a class="nav-link nav-item" href="{{ route('home') }}"><i class="fas fa-home mr-2"></i>Accueil</a>
                @include('includes.nav.shared-end')
            @elseif (SessionManager::isAdmin())
                <a class="nav-link nav-item" href="{{ route('home') }}"><i class="fas fa-home mr-2"></i>Accueil</a>
                <a class="nav-link nav-item" href="{{ route('validate') }}"><i class="fas fa-check-circle mr-2"></i>Valider</a>
                <div class="dropdown">
                    <span><i class="fas fa-list mr-2"></i>Gestion</span>
                    <div class="dropdown-content">
                        <a class="nav-link nav-item" href="{{ route('manage-leagues') }}"><i class="fas fa-list mr-2"></i>Gestion des ligues</a>
                        <a class="nav-link nav-item" href="{{ route('manage-parking-spaces') }}"><i class="fas fa-parking mr-2"></i>Gestion des places</a>
                    </div>
                </div>
                @include('includes.nav.shared-end')
            @endif

        </nav>
        @if (SessionManager::isLogged())
            <div class="text-center mb-2">
                <span>Vous êtes connecté en tant que {{ SessionManager::getFullTypeName() }}</span>
            </div>
        @endif
    </div>
</header>
<div class="ml-5 mr-5 mb-2">
    <main>
        <div>
            @include('includes.flash-message')
        </div>
        {{-- TODO Rework le système d'accès? Passer par un middleware? --}}
        @if ($access === ACCESS_PUBLIC)
            @yield('content')
        @elseif ($access === ACCESS_SEMIPUBLIC)
            @if (SessionManager::isLogged())
                @yield('content')
            @else
                @include('includes.access.semi-public')
            @endif
        @elseif ($access === ACCESS_ADMIN)
            @if (!SessionManager::isLogged())
                @include('includes.access.admin')
            @elseif (session('type') === 'admin')
                @yield('content')
            @else
                @include('includes.access.forbidden')
            @endif
        @endif
    </main>
</div>
</body>
</html>
