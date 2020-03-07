{{-- Si STATE_NEWLY_CREATED alors spécifier qu'il devra attendre validation de l'admin pour se connecter --}}
@php($url = \Illuminate\Support\Facades\URL::to("/reinitialiser-mot-de-passe/$reset_link"))
Vous avez demandé à réinitialiser votre mot de passe : <a href="{{ $url }}">{{ $url }}</a>

Ne faites rien si vous n'avez pas demandé cette réinitialisation, sinon cliquez sur le lien ci-dessus!
