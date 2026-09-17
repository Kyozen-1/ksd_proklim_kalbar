<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;

Route::prefix('login')->group(function(){
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'loginProcess'])->name('login-process');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

@include('backend.php');
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
Route::get('/berita/{id}', [HomeController::class, 'beritaDetail'])->name('berita-detail');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/laporan', [HomeController::class, 'laporan'])->name('laporan');

Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/edukasi', [HomeController::class, 'edukasi'])->name('edukasi');
Route::get('/program-aksi/{feature}', [HomeController::class, 'featureDevelopment'])
    ->where('feature', 'proklim|igrk|sampah|kualitas-lingkungan|lb3')
    ->name('feature-development');
Route::get('/edukasi/aksi-lingkungan', [HomeController::class, 'aksiLingkungan'])->name('aksi-lingkungan');
Route::get('/edukasi/aksi-lingkungan/{id}', [HomeController::class, 'aksiLingkunganDetail'])->name('aksi-lingkungan-detail');
Route::get('/data-proklim', [HomeController::class, 'data'])->name('data');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/media/berita/{id}', [HomeController::class, 'beritaImage'])->name('frontend.berita.image');
Route::get('/media/kegiatan/{id}', [HomeController::class, 'kegiatanImage'])->name('frontend.kegiatan.image');
Route::get('/media/dokumen/{id}', [HomeController::class, 'dokumenFile'])->name('frontend.dokumen.file');
Route::get('/media/anggota-pelaksana/{id}', [HomeController::class, 'anggotaImage'])->name('frontend.anggota-pelaksana.image');
Route::get('/media/landing/{id}/{field?}', [HomeController::class, 'landingImage'])->name('frontend.landing.image');
