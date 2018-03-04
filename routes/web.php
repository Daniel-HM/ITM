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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index', function () {
})->name('home');

Route::post('/', 'ArtikelsController@getArtikel', function () {
})->name('home');

Route::get('/artikel/{ean}', 'ArtikelsController@getArtikelByEan', function ($ean) {
});
Route::get('/laatst-nieuwe-artikels', 'ArtikelsController@showLastAddedArtikels')->name('laatst-nieuwe-artikels');
Route::get('/artikels-in-promotie', 'ArtikelsController@showArtikelsCurrentlyPromo')->name('artikels-in-promotie');
Route::get('/leveranciers', 'ArtikelsController@showLeveranciers')->name('leveranciers');
Route::get('/leverancier/{leverancier_id}', 'ArtikelsController@getLeverancierArtikels', function ($leverancier) {
});

Route::get('/upload', 'FilesController@index')->name('upload');
Route::post('/upload', 'FilesController@handleFile')->name('upload');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/leveringskosten', 'LeveringController@index')->name('leveringskosten');
Route::post('/leveringskosten', 'LeveringController@kosten');

Route::get('/add_user', 'UsersController@addUser')->middleware('isAdmin')->name('add_user');
Route::post('/add_user', 'UsersController@create')->middleware('isAdmin')->name('add_user');
