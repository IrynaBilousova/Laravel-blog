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

Route::get('/home', function () {
    return redirect('/posts');
});
Route::get('/', function () {
    return redirect('/posts');
});

Route::resource('posts', 'PostController')->except('show');
Route::get('posts/{category}', 'PostController@index')->name('posts_with_category');
Route::get('posts/{category}/{id}', 'PostController@show')->name('show_post');

Route::post('/posts/{category}/{id}' , 'CommentController@store');
Route::post('/posts/{category}/{id}/favorites' , 'FavoriteController@store');
Route::post('posts', 'PostController@store');
Auth::routes();


