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

function declareViewThenPost(string $url, string $path, int $access_level, string $action)
{
    $route = declareView($url, $path, $access_level);
    Route::post($route->uri(), $action);
    return $route;
}

// Changer mot de passe
declareViewThenPost('/changer-mot-de-passe', 'changer-mdp', ACCESS_PUBLIC, 'ChangePasswordController')
    ->name('change-password');

// Connexion
declareViewThenPost('/connexion', 'connexion', ACCESS_PUBLIC, 'LoginController')
    ->name('login');
Route::redirect('/', '/connexion')->name('home');

// Déconnexion
Route::get('/deconnexion', function () {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
})->name('logout');

// Inscription
declareViewThenPost('/inscription', 'inscription', ACCESS_PUBLIC, 'RegisterController')
    ->name('register');

// Mot de passe oublié
declareViewThenPost('/reinitialiser-mot-de-passe', 'reset', ACCESS_PUBLIC, 'ResetLinkController')
    ->name('reset-password');
Route::redirect('/reset', '/reinitialiser-mot-de-passe');

// Changer mdp avec lien
Route::get('/reinitialiser-mot-de-passe/{link}', function ($link) {
    Session::put('link', $link);
    return Redirect::to('/changer-mot-de-passe');
});

// Page validation
declareViewThenPost('/admin/valider', 'admin.valider', ACCESS_ADMIN, 'ValidationController')
    ->name('validate');

declareViewThenPost('/admin/gestion-ligues', 'admin.ligues', ACCESS_ADMIN, 'LeagueController')
    ->name('manage-leagues');

declareView('/admin/gestion-places', 'admin.places', ACCESS_ADMIN)
    ->name('manage-parking-spaces');
