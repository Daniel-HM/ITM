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
});

Route::get('/artikel/{ean}', 'ArtikelsController@getArtikelByEan', function ($ean) {
});
Route::get('/leverancier/{leverancier_id}', 'ArtikelsController@getLeverancierArtikels', function ($leverancier) {
});

Route::get('/upload', 'FilesController@index');
Route::post('/upload', 'FilesController@handleFile');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/levering', 'LeveringController@index')->name('levering');
Route::post('/levering', 'LeveringController@kosten');

Route::get('/scrape', 'ScrapeController@scrape');
