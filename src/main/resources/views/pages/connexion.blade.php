<form method="POST" class="form-signin p-2">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1 class="center text-white mb-4 font-weight-normal">Connexion</h1>
    <label for="mail" class="sr-only">Adresse Mail</label>
    <input type="text" name="mail" class="form-control mb-1" placeholder="Adresse Mail" required autofocus>
    <label for="mdp" class="sr-only">Mot de Passe</label>
    <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de Passe" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Se Connecter</button>
</form>
<a href="/inscription" class="btn-block mb-3 pl-4">S'inscrire</a>
