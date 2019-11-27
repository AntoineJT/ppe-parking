<form method="POST" class="form-signin p-2">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1 class="center text-white mb-3 font-weight-normal">Réinitialiser son mot de passe</h1>
    <p class="center font-italic mb-4">Veuillez indiquer votre adresse mail.
        <br>Nous vous enverrons de quoi récupérer votre compte s'il existe.
    </p>
    <label for="mail" class="sr-only">Adresse Mail</label>
    <input type="text" name="mail" class="form-control mb-3" placeholder="Adresse Mail" required autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Se Connecter</button>
</form>
