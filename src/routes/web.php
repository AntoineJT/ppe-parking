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

/*
function embedInMainView(string $content, string $title, int $access_level) : string
{
    return view('main', [
        'title' => $title,
        'content' => $content,
        'access' => $access_level
    ]);
}

function declareSubpageByPath(string $path, string $title, int $access_level) {
    return declareSubpage($path, $path, $title, $access_level);
}

function declareSubpage(string $name, string $path, string $title, int $access_level) {
    return Route::get($name, function() use($title, $path, $access_level) {
        $content = view("pages/$path");
        return embedInMainView($content, $title, $access_level);
    });
}
*/

// Changer mot de passe
/*
Route::get('/changer-mot-de-passe', function() {
    $content = view('pages/changer-mdp', [
        'link' => ''
    ]);
    return embedInMainView($content, 'Changer votre mot de passe', ACCESS_PUBLIC);
})->name('change-password');
Route::post('/changer-mot-de-passe', 'ChangePasswordController');
*/

// Connexion
Route::redirect('/', '/connexion')->name('home');

Route::view('/connexion', 'connexion', [
    'access' => ACCESS_PUBLIC
])->name('login');

Route::post('/connexion', 'LoginController');


// Déconnexion
Route::get('/deconnexion', function() {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
})->name('logout');

// Inscription
Route::view('/inscription', 'inscription', [
    'access' => ACCESS_PUBLIC
])->name('register');
Route::post('/inscription', 'RegisterController');

// Mot de passe oublié
/*
Route::get('/reinitialiser-mot-de-passe', function() {
    $content = view('pages/reset', [
        'link' => ''
    ]);
    return embedInMainView($content, 'Réinitialisation du mot de passe', ACCESS_PUBLIC);
})->name('reset-password');
Route::post('/reinitialiser-mot-de-passe', 'ResetLinkController');
Route::redirect('/reset', '/reinitialiser-mot-de-passe');
*/

// Changer mdp avec lien
/*
Route::get('/reinitialiser-mot-de-passe/{link}', function($link) {
    Session::put('link', $link);
    return Redirect::to('/changer-mot-de-passe');
});
*/

// Page validation
/*
declareSubpageByPath('/admin/valider', 'Valider les comptes', ACCESS_ADMIN)->name('validate');
Route::post('/admin/valider', 'ValidationController');
*/
