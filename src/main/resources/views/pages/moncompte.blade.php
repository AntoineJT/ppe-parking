<form method="POST" class="form-signin p-2">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <fieldset>
      <legend>Changement mot de passe</legend>
      <label for="mail" class="sr-only">Votre Mail</label>
      <input type="email" name="mail" class="form-control mb-1" placeholder="Adresse Mail" required>
      <label for="mdp" class="sr-only">Ancien Mot de Passe</label>
      <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de Passe" required>
      <label for="mdp" class="sr-only">Nouveau Mot de Passe</label>
      <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de Passe" required><br>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Valider</button>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Annuler</button>
    </fieldset>
</form>
