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

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
 * pagelist
 *
    /
    /connexion
    /deconnexion
    /inscription
    /recuperationcompte
    /consultation
    /consultation/places
    /consultation/historique
    /consultation/statut
    /reservation/creer
    /moncompte
    /admin
    /admin/connexion
    /admin/gestion/utilisateurs
    /admin/gestion/places
    /admin/gestion/file

 */

function embedInMainView(string $content, bool $public, bool $admin)
{
    /*
    if (session('compte') == NULL) {
        return Redirect::to('login');
    }
    */
    return view('main', [
        'title' => 'Accueil',
        'content' => $content,
        'publicContent' => $public,
        'admin' => $admin
    ]);
}

function embedPageInMainView(string $path, bool $public, bool $admin) {
    $content = view('pages/' . $path);
    return embedInMainView($content, $public, $admin);
}

function declareSubpage(string $path, bool $public, bool $admin) {
    Route::get($path, function() use ($admin, $public, $path) {
        return embedPageInMainView($path, $public, $admin);
    });
}

// TODO Replace with the good one
Route::get('/', function () {
    //return view('welcome');
    return view('main', [
        'title' => 'Accueil',
        'publicContent' => true,
        'content' => '',
        'admin' => false
    ]);
});

Route::get('deconnexion', function() {
    Request::session()->remove('compte');
    return Redirect::to('connexion');
});

declareSubPage('presentation', true, false);
declareSubpage('connexion', true, false);
declareSubpage('inscription', true, false);
