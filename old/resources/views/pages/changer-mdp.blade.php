<style>
    .container {
        padding-bottom: 1rem;
        width: 32.5rem;
    }
</style>
@if (session('link') !== NULL || \App\Utils\SessionManager::isLogged())
    <div class="container bg-white shadow-sm">
        <p class="text-center h1">Changer de mot de passe
        <div class="d-flex justify-content-center mt-3 flex-xl-row flex-lg-row flex-sm-column">
            <form method="POST" class="form-group">
                @csrf
                <div class="d-flex flex-column">
                    <input name="link" type="hidden" value="{{ session('link') }}">
                    <input name="motdepasse" type="password" placeholder="Mot de passe" class="form-control" required>
                    <input name="verifmotdepasse" type="password" placeholder="Vérification mot de passe"
                           class="form-control mt-1" required>
                    <button type="submit" class="btn btn-primary mt-2">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
@else
    <p style="color:red; font-size:3rem;">Vous devez vous <a style="color:green" href="/connexion">connecter</a>
        pour accéder à ce contenu!</p>
@endif
