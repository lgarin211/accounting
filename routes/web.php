<?php

use Illuminate\Support\Facades\Route;

//auth management
Route::get('/', 'AuthController@loginView');
Route::post('/login', 'AuthController@login')->name('login');
Route::post('/logout', 'AuthController@logout')->name('logout');
Route::get('register', function () {
    return view('_auth/register');
});

Route::middleware('auth')->group(function () {
    Route::get('home', 'HomeController@home')->name('home');
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
        // Jurnal Umum
        Route::resource('jurnalumum', 'JurnalUmumController');
        // Buku Besar
        Route::get('/bukubesar', 'BukuBesarController@index')->name('bukubesar.index');
        // Kategori
        Route::resource('kategori', 'KategoriController');
        // Kontak
        Route::resource('kontak', 'KontakController');
    });
});

