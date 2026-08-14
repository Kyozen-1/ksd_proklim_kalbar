<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes - Public Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pslb3pp', [HomeController::class, 'pslb3pp'])->name('pslb3pp');
Route::get('/program-aksi', [HomeController::class, 'data'])->name('program-aksi');
Route::get('/regulasi', [HomeController::class, 'regulasi'])->name('regulasi');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/detail', [HomeController::class, 'beritaDetail'])->name('berita-detail');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/laporan', [HomeController::class, 'laporan'])->name('laporan');

Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/edukasi', [HomeController::class, 'edukasi'])->name('edukasi');
Route::get('/edukasi/aksi-lingkungan', [HomeController::class, 'aksiLingkungan'])->name('aksi-lingkungan');
Route::get('/edukasi/aksi-lingkungan/detail', [HomeController::class, 'aksiLingkunganDetail'])->name('aksi-lingkungan-detail');
Route::get('/data-proklim', [HomeController::class, 'data'])->name('data');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
