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
Route::group([
    'prefix' => 'view'
], function () {
    Route::get('home', 'HomeController@index')->name('login');
    Route::get('blog-after-login', 'HomeController@blogAfterLogin')->middleware('auth:api');
    Route::get('edit-blog', 'HomeController@editItem')->middleware('auth:api')->name('edit-record');
});
