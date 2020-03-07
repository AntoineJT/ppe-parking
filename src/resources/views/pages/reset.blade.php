<div class="d-flex justify-content-center text-center">
    <form method="POST">
        @csrf
        <p class="h1">Réinitialiser le mot de passe</p>
        <p class="mb-4">Pour réinitialiser votre mot de passe, renseignez l'adresse de courriel avec laquelle vous avez
            été inscrit.
            <br>Si cette adresse e-mail est effectivement associée à un compte, vous recevrez un mail vous permettant
            d'en changer le mot de passe.
        </p>
        <input type="email" name="courriel" placeholder="Adresse e-mail" required>
        <button class="pl-3 pr-3 pb-1 pt-1 border-0 text-white bg-dark" type="submit">Réinitialiser le mot de passe
        </button>
    </form>
</div>
