<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Future Expansion)
|--------------------------------------------------------------------------
|
| Here is where you can register admin / backend CMS routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware group.
|
*/

Route::get('/', function () {
    return view('admin.dashboard.index');
})->name('dashboard');
