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

Auth::routes();

Route::get('/', 'HomeController@index', function () {
})->name('home');
Route::post('/', 'ArtikelsController@getArtikel', function () {
});

Route::get('/ean/{ean}', 'ArtikelsController@getArtikelByEan', function ($ean) {
});
Route::get('/leverancier/{leverancier}', 'ArtikelsController@getArtikelsOfLeverancier', function ($leverancier) {
});

Route::get('/setdb', 'DatabaseController@insertDB');
Route::get('/setlev', 'DatabaseController@insertLeveranciers');
Route::get('/setgroepen', 'DatabaseController@insertGroepen');


Route::get('/upload', 'FilesController@index');
Route::post('/upload', 'FilesController@handleFile');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
