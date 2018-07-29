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

Route::get('home', function () {
    return redirect('/posts');
});
Route::get('/', function () {
    return redirect('/posts');
});
Auth::routes();

Route::resource('posts', 'PostController')->except('show');
Route::get('posts/{category}', 'PostController@index')->name('posts_with_category');
Route::get('posts/{category}/{post}', 'PostController@show')->name('show_post');
Route::delete('posts/{category}/{post}', 'PostController@destroy');
Route::post('posts/{category}/{post}' , 'CommentController@store');
Route::get('posts/{category}/{post}/comments' , 'CommentController@index');//TODO: change route to more appropriate
Route::post('posts/{category}/{post}/favorites' , 'FavoriteController@store');
Route::delete('posts/{category}/{post}/favorites' , 'FavoriteController@destroy');
Route::post('posts', 'PostController@store');
Route::delete('comments/{comment}', 'CommentController@destroy');
Route::patch('comments/{comment}', 'CommentController@update');
Route::get('profiles/{user}', 'ProfileController@show')->name('profile');
