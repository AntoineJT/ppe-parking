{{--Faire un header stylé avec logo etc.--}}
Vous avez demandé à réinitialiser votre mot de passe : <a href="{{ \Illuminate\Support\Facades\URL::to('/reinitialiser-mot-de-passe/') . $reset_link }}">{{ $url . $reset_link }}</a>

Ne faites rien si vous n'avez pas demandé cette réinitialisation, sinon cliquez sur le lien ci-dessus!
