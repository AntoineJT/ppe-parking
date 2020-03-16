<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Utils\FlashMessage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

const ACCESS_PUBLIC = 0;
const ACCESS_SEMIPUBLIC = 1;
const ACCESS_ADMIN = 2;

function declareView(string $url, string $path, int $access_level)
{
    return Route::view($url, $path, [
        'access' => $access_level
    ]);
}

// Changer mot de passe
declareView('/changer-mot-de-passe', 'changer-mdp', ACCESS_PUBLIC)
    ->name('change-password');
Route::post('/changer-mot-de-passe', 'ChangePasswordController');

// Connexion
Route::redirect('/', '/connexion')->name('home');
declareView('/connexion', 'connexion', ACCESS_PUBLIC)
    ->name('login');
Route::post('/connexion', 'LoginController');


// Déconnexion
Route::get('/deconnexion', function () {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
})->name('logout');

// Inscription
declareView('/inscription', 'inscription', ACCESS_PUBLIC)
    ->name('register');
Route::post('/inscription', 'RegisterController');

// Mot de passe oublié
declareView('/reinitialiser-mot-de-passe', 'reset', ACCESS_PUBLIC)
    ->name('reset-password');
Route::post('/reinitialiser-mot-de-passe', 'ResetLinkController');
Route::redirect('/reset', '/reinitialiser-mot-de-passe');

// Changer mdp avec lien
Route::get('/reinitialiser-mot-de-passe/{link}', function($link) {
    Session::put('link', $link);
    return Redirect::to('/changer-mot-de-passe');
});

// Page validation
declareView('/admin/valider', 'admin.valider', ACCESS_ADMIN)
    ->name('validate');
Route::post('/admin/valider', 'ValidationController');

// Retourner les vues pour travailler dessus
declareView('/home', 'home', ACCESS_PUBLIC)
    ->name('home');
