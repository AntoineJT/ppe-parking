<div class="d-flex justify-content-center text-center">
    <form method="POST" class="p-4 form-group">
        @csrf
        <p class="h1">Formulaire d'inscription</p>
        <p>
            <i class="fas fa-exclamation-triangle mr-2"></i>Il s'agit d'une plateforme interne<br>
            Vous devez confirmer votre adresse mail!<br>
            Votre compte sera désactivé jusqu'à ce que l'administrateur l'approuve!
        </p>
        <div class="d-flex flex-column container mt-3">
            <input name="nom" type="text" placeholder="Nom" class="form-control" required>
            <input name="prenom" type="text" placeholder="Prénom" class="form-control" required>
            <input name="courriel" type="email" placeholder="Adresse e-mail" class="form-control" required>
            <input name="mdp" type="password" placeholder="Mot de passe" class="form-control" required>
            <button class="pl-3 pr-3 pb-1 pt-1 mt-2 btn btn-primary" type="submit">S'enregistrer!</button>
        </div>
    </form>
</div>
