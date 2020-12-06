<?php

use Illuminate\Support\Facades\Route;

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

Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@authenticate')->name('authenticate');

Route::group( ['middleware' => ['auth', 'check.company'] ], function()
{
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::post('category', 'CategoryController@create')->name('category.create');

});


