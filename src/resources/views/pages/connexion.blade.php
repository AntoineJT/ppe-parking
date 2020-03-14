<div class="login-form m-auto">
    <form method="POST">
        @csrf
        <div class="text-center"><h3>Se connecter</h3></div></br>
          <div class="form-group">
            <input class="form-control" name="courriel" placeholder="Adresse e-mail" type="email" required>
          </div>
          <div class="form-group">
            <input class="form-control" name="password" placeholder="Mot de passe" type="password" required>
          </div></br>
            <button class="btn-block btn btn-primary btn-b" type="submit">Se connecter</button></br>
        <div>
          <a class="col-1" href="{{ route('register') }}"><i>Pas encore inscrit ?</i></a>
          <a class="col-1" href="{{ route('reset-password') }}" class="white-relief"><i>Mot de passe oublié ?</i></a>
        </div>
    </form>
</div>
