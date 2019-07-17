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

App::setLocale('fr');

/* PAGES */
Route::get('/', 'PagesController@index')->name('index');
Route::get('/jeux', 'PagesController@jeux')->name('jeux');
Route::get('/stats/{uuid?}', 'PagesController@stats')->name('stats');
Route::get('/reglement', 'PagesController@reglement')->name('reglement');
Route::get('/staff', 'PagesController@staff')->name('staff');
Route::get('/boutique', 'PagesController@boutique')->name('boutique');

Route::get('/cgu', 'PagesController@cgu')->name('cgu');
Route::get('/cgv', 'PagesController@cgv')->name('cgv');
Route::post('/bug', 'PagesController@bug');

/* POSTS */
Route::post('/posts/new', 'PostsController@store');
Route::post('/posts/delete', 'PostsController@delete');

Route::post('/games/new', 'GamesController@store');
Route::post('/games/delete', 'GamesController@delete');

Route::post('/rules/new', 'RulesController@store');
Route::post('/rules/update', 'RulesController@update');
Route::post('/rules/delete', 'RulesController@delete');

Route::get('/admin', 'AdminController@panel')->middleware('admin.login')->name('admin.panel');
Route::get('/admin/login', 'AdminController@showLoginForm')->name('admin.login');
Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');
Route::post('/admin/login', 'AdminController@login');
Route::middleware(['admin.login'])->group(function () {
    Route::post('/admin/video/edit', 'AdminController@updateVideo');
    Route::post('/admin/slogan/edit', 'AdminController@updateSlogan');
    Route::post('/admin/staff/add', 'AdminController@addStaff');
    Route::post('/admin/staff/remove', 'AdminController@removeStaff');
    Route::post('/admin/maintenance', 'AdminController@toggleMaintenanceMode');
    Route::post('/admin/password/edit', 'AdminController@changePassword');
});

Route::get('discord', function () {
    return redirect('https://discordapp.com/invite/VT8KrUb');
});
