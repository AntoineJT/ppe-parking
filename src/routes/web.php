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

function embedInMainView(string $content, string $title, int $access_level) : string
{
    return view('main', [
        'title' => $title,
        'content' => $content,
        'access' => $access_level
    ]);
}

function declareSubpageByPath(string $path, string $title, int $access_level) : void {
    declareSubpage($path, $path, $title, $access_level);
}

function declareSubpage(string $name, string $path, string $title, int $access_level) : void {
    Route::get($name, function() use($title, $path, $access_level) {
        $content = view("pages/$path");
        return embedInMainView($content, $title, $access_level);
    });
}

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::redirect('/', '/connexion');
declareSubpageByPath('/connexion', 'Connexion', ACCESS_PUBLIC);

declareSubpageByPath('/inscrire', "S'enregistrer", ACCESS_PUBLIC);

Route::get('/deconnexion', function() {
    Request::session()->flush();
    return FlashMessage::redirectWithInfoMessage(Redirect::to('/'), 'Vous vous êtes déconnecté!');
});
