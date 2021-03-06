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

Route::get('/', 'InputController@index');
Route::post('/store', 'InputController@JaroWinkler'); 
Route::get('/tabel-verba', 'InputController@verba');
Route::get('/cari-verba', 'InputController@cari');
Route::get('/tentang-kami', 'InputController@tentang');