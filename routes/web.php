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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middlewere' => 'auth'], function() {
    
    Route::resource('conta', 'ContasController');
    Route::resource('ccusto', 'CcustosController');
    Route::resource('fundofixo', 'FundofixosController');
    Route::resource('item', 'ItensController');
   // Route::get('item/{id}','ItensController@getnr')->name('getnr');
    
});

