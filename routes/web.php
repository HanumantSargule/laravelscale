<?php
Route::view('/', 'listings.index')->name('listings.index');
//for register
Route::get('/register', function () {
    return view('auth.register');
});
//for login
Route::get('/login', function () {
    return view('auth.login');
});
