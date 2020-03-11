
<div class="mdp-form m-auto">
    <form method="POST">
        @csrf
        <div class="text-center"><h3>Réinitialiser le mot de passe</h3></div></br>
        <p>
            <i class="fas fa-exclamation-triangle mr-2"></i><i>Pour réinitialiser votre mot de passe, renseignez l'adresse de courriel avec laquelle vous avez
                été inscrit.
                <br>Si cette adresse e-mail est effectivement associée à un compte, vous recevrez un mail vous permettant
                d'en changer le mot de passe.</i>
        </p></br>
          <div class="form-group">
            <input class="form-control" name="courriel" type="email" placeholder="Votre e-mail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
          </div>
          <button class="btn-block btn btn-primary btn-b" type="submit">Réinitialiser le mot de passe</button>
    </form>
</div>
