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
Route::get('/add-job/{id?}', 'JobController@show')->name('add-job');
Route::get('/profile', 'HomeController@profileShow')->name('profile');
Route::post('/store-job', 'JobController@store')->name('store-job');
Route::post('/update-profile', 'HomeController@profileUpdate')->name('update-profile');
Route::get('/apply-job/{id}', 'JobController@apply')->name('apply-job');
Route::get('/destroy-job/{id}', 'JobController@destroy')->name('destroy-job');
