@extends('layout.app')
@section('title', 'Réinitialisation du mot de passe')

@section('content')
    <div class="mdp-form m-auto">
        <form method="POST">
            @csrf
            <div class="text-center"><h3>Réinitialiser le mot de passe</h3></div>
            <p class="mt-4 font-italic">
                <i class="fas fa-exclamation-triangle mr-2"></i>Pour réinitialiser votre mot de passe, renseignez
                l'adresse de courriel avec laquelle vous avez
                été inscrit.
                <br>Si cette adresse e-mail est effectivement associée à un compte, vous recevrez un mail vous
                permettant
                d'en changer le mot de passe.
            </p>
            <div class="form-group mt-4">
                <input class="form-control" name="courriel" type="email" placeholder="Adresse de courriel"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            </div>
            <button class="btn-block btn btn-primary btn-b" type="submit">Réinitialiser le mot de passe</button>
        </form>
    </div>
@endsection
