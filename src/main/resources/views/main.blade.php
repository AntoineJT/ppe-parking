<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>M2L - {{ $title }}</title>
    <meta charset="utf8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/cssGeneral.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="ml-5 mr-5 p-3 mb-2 bg-dark text-dark">
<div class="p-3 mb-2 bg-info text-white">
    Maison des Ligues<br>
    🅿️ Parking
    <img src="{{ asset('images/mdl.png') }}" class="rounded float-right" alt="Responsive image">
</div>
<nav class="m-2 nav nav_pills nav-fill">
    @if (!$admin)
        @if (session('compte') == NULL)
            <a class="nav-link nav-item" href="/presentation"><i class="fas fa-home"></i>&nbsp&nbspPrésentation</a>
            <a class="nav-link nav-item" href="/connexion"><i class="fas fa-home"></i>&nbsp&nbspConnexion</a>
        @else
            <a class="nav-link nav-item" href="/accueil"><i class="fas fa-home"></i>&nbsp&nbspAccueil</a>
            <a class="nav-link nav-item" href="/reservation/creer"><i class="fas fa-home"></i>&nbsp&nbspNouvelle Réservation</a>
            <a class="nav-link nav-item" href="/consultation/historique"><i class="fas fa-home"></i>&nbsp&nbspHistorique des Réservations</a>
            <a class="nav-link nav-item" href="/deconnexion">Déconnexion&nbsp&nbsp<i class="fas fa-sign-out-alt"></i></a>
        @endif
    @else
        @if (session('compte') != NULL)
            <a class="nav-link nav-item" href="/admin/accueil"><i class="fas fa-home"></i>&nbsp&nbspAccueil</a>
            <a class="nav-link nav-item" href="/admin/gestion/utilisateurs"><i class="fas fa-home"></i>&nbsp&nbspGestion Utilisateurs</a>
            <a class="nav-link nav-item" href="/admin/gestion/places"><i class="fas fa-home"></i>&nbsp&nbspGestion des places</a>
            <a class="nav-link nav-item" href="/admin/gestion/historique"><i class="fas fa-home"></i>&nbsp&nbspListe d'attente</a>
            <a class="nav-link nav-item" href="/admin/deconnexion">Déconnexion&nbsp&nbsp<i class="fas fa-sign-out-alt"></i></a>
        @endif
    @endif
</nav>
@if (!$admin)
    @if ($publicContent || session('compte') != NULL)
        {!! $content !!}
    @endif
@else
    @if (session('compte') == NULL)
        <p style="color:white; font-size:3rem;">Vous devez vous connecter pour accéder au panel administrateur</p>
    @else
        {!! $content !!}
    @endif
@endif
</body>
</html>
