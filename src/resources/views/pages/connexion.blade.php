<div class="d-flex justify-content-center mt-5 flex-xl-row flex-lg-row flex-sm-column">
    <form method="POST" class="text-white text-center mr-4 rounded-pill mb-2">
        @csrf
        <div class="text-center font-weight-bold mb-2 text-dark">Se connecter</div>
        <div class="d-flex flex-column mb-1">
            <input name="courriel" placeholder="Adresse e-mail" type="email" class="form-control rounded-0" required>
            <input name="password" placeholder="Mot de passe" type="password" class="form-control rounded-0" required>
        </div>
        <a href="/reset" class="white-relief">Mot de passe oublié?</a>
        <div class="d-flex justify-content-center mt-3">
            <button class="pl-3 pr-3 pb-1 btn btn-primary" type="submit">Se connecter</button>
        </div>
    </form>
</div>
