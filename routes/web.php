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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middlewere' => 'auth'], function () {
    Route::resource('conta', 'ContasController')->except([
        'create','edit'
    ]);

    Route::resource('ccusto', 'CcustosController')->except([
        'create','edit'
    ]);

    Route::resource('fundofixo', 'FundofixosController');

    Route::prefix('fundofixo')->group(function () {
        Route::get('adiciona-item/{item}/', 'FundofixosController@adicionaItem')->name('fundofixo.adicionaItem');
        Route::resource('item', 'ItensController')->except([
            'index','create','edit'
        ]);
        Route::post('gerar-pdf/{fundofixo}', 'FundofixosController@gerarPdf')->name('gerarPdf');
    });
});
