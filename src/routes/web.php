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

const ACCESS_PUBLIC = 0;
const ACCESS_SEMIPUBLIC = 1;
const ACCESS_ADMIN = 2;

function declareView(string $url, string $path, int $access_level)
{
    return Route::view($url, $path, [
        'access' => $access_level
    ]);
}

// Accueil
Route::redirect('/', '/connexion')->name('home');

// Section admin
Route::prefix('/admin')->group(function () {
    // Paramètres généraux
    Route::prefix('/configuration')->group(function() {
        Route::get('/', 'ConfigurationController@show')->name('config');
        Route::post('/', 'ConfigurationController');
    });

    // Gestion ligues
    Route::prefix('/gestion-ligues')->group(function () {
        declareView('/', 'admin.ligues', ACCESS_ADMIN)->name('manage-leagues');
        Route::post('/', 'LeagueController');
    });

    // Gestion places
    Route::prefix('/gestion-places')->group(function () {
        declareView('/', 'admin.places', ACCESS_ADMIN)->name('manage-parking-spaces');
        Route::post('/', 'ParkingSpaceController');
    });

    // Gestion utilisateurs
    Route::prefix('/gestion-utilisateurs')->group(function () {
        declareView('/', 'admin.utilisateurs', ACCESS_ADMIN)->name('manage-users');
        Route::post('/', 'UserController');
    });
});

// Changer mot de passe
Route::prefix('/changer-mot-de-passe')->group(function () {
    declareView('/', 'changer-mdp', ACCESS_PUBLIC)->name('change-password');
    Route::post('/', 'ChangePasswordController');
});

// Connexion
Route::prefix('/connexion')->group(function () {
    declareView('/', 'connexion', ACCESS_PUBLIC)->name('login');
    Route::post('/', 'LoginController');
});

// Déconnexion
Route::get('/deconnexion', function () {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
})->name('logout');

// Inscription
Route::prefix('/inscription')->group(function () {
    declareView('/', 'inscription', ACCESS_PUBLIC)->name('register');
    Route::post('/', 'RegisterController');
});

// Mot de passe oublié
Route::prefix('/reinitialiser-mot-de-passe')->group(function () {
    declareView('/', 'reset', ACCESS_PUBLIC)->name('reset-password');
    Route::post('/', 'ResetLinkController');
});
Route::redirect('/reset', '/reinitialiser-mot-de-passe');

// Changer mdp avec lien
Route::get('/reinitialiser-mot-de-passe/{link}', 'ResetLinkController@withLink')->name('reset-link');

// Réservations
Route::prefix('/reservation')->group(function () {
    declareView('/', 'reservation', ACCESS_SEMIPUBLIC)->name('reserve');
    Route::post('/', 'ReservationController');
});
