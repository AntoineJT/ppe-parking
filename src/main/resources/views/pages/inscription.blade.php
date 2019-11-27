<form method="POST" class="form-signin p-2">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1 class="center text-white mb-4 font-weight-normal">Inscription</h1>
    <label for="nom" class="sr-only">Nom</label>
    <input type="text" name="nom" class="form-control mb-1" placeholder="Nom" required autofocus>
    <label for="prenom" class="sr-only">Prénom</label>
    <input type="text" name="prenom" class="form-control mb-1" placeholder="Prenom" required>
    <label for="ligue" class="sr-only text-white">Ligue</label>
    <select name="ligue" class="form-control mb-5" required>
        <option selected value="">-- Sélectionnez une ligue --</option>
        @php
            // TODO Générer auto des <option> en parcourant le contenu de la db
        @endphp
    </select>
    <label for="mail" class="sr-only">Adresse Mail</label>
    <input type="email" name="mail" class="form-control mb-1" placeholder="Adresse Mail" required>
    <label for="mdp" class="sr-only">Mot de Passe</label>
    <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de Passe" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
</form>
