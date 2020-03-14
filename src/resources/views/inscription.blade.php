@extends('layouts.app')
@section('title', "S'enregistrer")

@section('content')
    <div class="register-form m-auto">
        <form method="POST">
            @csrf
            <div class="text-center"><h3>Formulaire d'inscription</h3></div>
            <p class="mt-4">
                <i class="fas fa-exclamation-triangle mr-2"></i><i>Il s'agit d'une plateforme interne!<br>
                    Un mail vous sera envoyé avec un lien de réinitialisation vous permettra de choisir un mot de passe
                    et
                    de vérifier votre adresse mail.<br>
                    Votre compte sera désactivé jusqu'à ce que l'administrateur l'approuve !</i>
            </p>
            <div class="form-group mt-4">
                <input class="form-control" name="nom" type="text" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <input class="form-control" name="prenom" type="text" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <input class="form-control" name="courriel" type="email" placeholder="Adresse e-mail"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            </div>
            <select name="ligue" class="form-control">
                <option value="" selected disabled>Ligue</option>
                @foreach(App\Models\Ligue::all() as $ligue)
                    <option value="{{ $ligue->id }}">{{ $ligue->nom }}</option>
                @endforeach
            </select>
            <button class="btn-block btn btn-primary btn-b mt-4" type="submit">S'enregistrer</button>
            <div class="mt-2 font-italic text-center"><a href="{{ route('login') }}">Se connecter</a></div>
        </form>
    </div>
@endsection
