<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>PPE Parking - {{ $title }}</title>
    <meta charset="utf8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="/css/vendor/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <link rel="shotcut icon" href="{{ asset('images/favicon.ico')}}"/>
    <link href="https://fonts.googleapis.com/css?family=Sigmar+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <script src="/js/flash-message.js" type="text/javascript"></script>
</head>
@php
    use \App\Utils\SessionManager;
@endphp
<body class="bg-white text-dark">
<header class="bg-white">
  <div class="container">
      <nav class="navbar shadow-sm p-3 mb-5 navbar-expand-lg navbar-light bg-light rounded mt-4 ">
        <div class="col-7 nav-log">
        <b>Parking</b>
        </div>
        <div class="col-2"></div>
        @if (!SessionManager::isLogged())
            <a class="nav-link nav-item" href="/"><i class="fas fa-home mr-2"></i>Accueil</a>
            <a class="nav-link nav-item" href="/connexion"><i class="fas fa-sign-in-alt mr-2"></i>Connexion</a>
        @elseif (SessionManager::isPersonnel())
            <a class="nav-link nav-item" href="/"><i class="fas fa-home mr-2"></i>Accueil</a>
            <a class="nav-link nav-item" href="/deconnexion"><i class="fas fa-running mr-2"></i>Déconnexion</a>
        @elseif (SessionManager::isAdmin())
            <a class="nav-link nav-item" href="/"><i class="fas fa-home mr-2"></i>Accueil</a>
            <a class="nav-link nav-item" href="/deconnexion"><i class="fas fa-running mr-2"></i>Déconnexion</a>
        @endif

      </nav>
    @if (SessionManager::isLogged())
        <div class="text-center mb-2">
            <span>Vous êtes connecté en tant que {{ SessionManager::getFullTypeName() }}</span>
        </div>
    @endif
</header>
<div class="ml-5 mr-5 mb-2">
    <main>
        <div>
            @include('includes.flash-message')
        </div>
        @if ($access === ACCESS_PUBLIC)
            {!! $content !!}
        @elseif ($access === ACCESS_SEMIPUBLIC)
            @if (SessionManager::isLogged())
                {!! $content !!}
            @else
                @include('includes.access.semi-public')
            @endif
        @elseif ($access === ACCESS_ADMIN)
            @if (!SessionManager::isLogged())
                @include('includes.access.admin')
            @elseif (session('type') === 'admin')
                {!! $content !!}
            @else
                @include('includes.access.forbidden')
            @endif
        @endif
    </main>
</div>
</body>
</html>
