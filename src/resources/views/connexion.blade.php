@extends('layout.app')
@section('title', 'Connexion')

@section('content')
    <div class="login-form m-auto">
        <form method="POST">
            @csrf
            <div class="text-center"><h3>Se connecter</h3></div>
            <div class="form-group mt-4">
                <input class="form-control" name="courriel" placeholder="Adresse e-mail" type="email" required>
            </div>
            <div class="form-group">
                <input class="form-control" name="password" placeholder="Mot de passe" type="password" required>
            </div>
            <button class="btn-block btn btn-primary btn-b mt-4" type="submit">Se connecter</button>
            <div class="mt-4">
                <a class="col-1 font-italic" href="{{ route('register') }}">Pas encore inscrit ?</a>
                <a class="col-1 font-italic" href="{{ route('reset-password') }}">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>
@endsection
