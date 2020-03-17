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

use App\Models\LienReset;
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

Route::redirect('/', '/connexion')->name('home');

Route::prefix('/admin')->group(function () {
    Route::prefix('/configuration')->name('config')->group(function() {
        Route::get('/', 'ConfigurationController@show');
        Route::post('/', 'ConfigurationController');
    });
    
    Route::prefix('/gestion-ligues')->name('manage-leagues')->group(function () {
        declareView('/', 'admin.ligues', ACCESS_ADMIN);
        Route::post('/', 'LeagueController');
    });

    Route::prefix('/gestion-places')->name('manage-parking-spaces')->group(function () {
        declareView('/', 'admin.places', ACCESS_ADMIN);
        Route::post('/', 'ParkingSpaceController');
    });

    Route::prefix('/gestion-utilisateurs')->name('manage-users')->group(function () {
        declareView('/', 'admin.utilisateurs', ACCESS_ADMIN);
        Route::post('/', 'UserController');
    });
});

Route::prefix('/changer-mot-de-passe')->name('change-password')->group(function () {
    declareView('/', 'changer-mdp', ACCESS_PUBLIC);
    Route::post('/', 'ChangePasswordController');
});

Route::prefix('/connexion')->name('login')->group(function () {
    declareView('/', 'connexion', ACCESS_PUBLIC);
    Route::post('/', 'LoginController');
});

Route::get('/deconnexion', function () {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
})->name('logout');

Route::prefix('/inscription')->name('register')->group(function () {
    declareView('/', 'inscription', ACCESS_PUBLIC);
    Route::post('/', 'RegisterController');
});

Route::prefix('/reinitialiser-mot-de-passe')->name('reset-password')->group(function () {
    declareView('/', 'reset', ACCESS_PUBLIC);
    Route::post('/', 'ResetLinkController');
});
Route::redirect('/reset', '/reinitialiser-mot-de-passe');

Route::get('/reinitialiser-mot-de-passe/{link}', function ($link) {
    Session::put('link', $link);
    $to = Redirect::to(route('change-password'));

    $reset_link = LienReset::find($link);
    if ($reset_link === null)
        return $to;

    $user = $reset_link->getUser();
    return $to->with('info', "Vous allez changer le mot de passe de l'utilisateur " . $user->getFullName());
})->name('reset-link');

Route::prefix('/reservation')->name('reserve')->group(function () {
    declareView('/', 'reservation', ACCESS_SEMIPUBLIC);
    Route::post('/', 'ReservationController');
});
