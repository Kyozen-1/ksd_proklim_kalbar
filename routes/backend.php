<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\DokumenController;
use App\Http\Controllers\Backend\AnggotaPelaksanaController;
use App\Http\Controllers\Backend\MasterData\JabatanController;

Route::middleware(['auth'])->prefix('cms')->group(function(){
    Route::middleware('check_role:superadmin,admin')->group(function(){
        Route::prefix('dashboard')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('cms.dashboard.index');
        });

        Route::prefix('berita')->group(function(){
            Route::get('/',[BeritaController::class, 'index'])->name('cms.berita.index');
            Route::get('/create',[BeritaController::class, 'create'])->name('cms.berita.create');
            Route::get('/datatable',[BeritaController::class, 'datatable'])->name('cms.berita.datatable');
            Route::post('/',[BeritaController::class, 'store'])->name('cms.berita.store');
            Route::get('/edit/{id}',[BeritaController::class, 'edit'])->name('cms.berita.edit');
            Route::post('/update/{id}',[BeritaController::class, 'update'])->name('cms.berita.update');
            Route::get('/destroy/{id}',[BeritaController::class, 'destroy'])->name('cms.berita.destroy');
        });

        Route::prefix('faq')->group(function(){
            Route::get('/', [FaqController::class, 'index'])->name('cms.faq.index');
            Route::get('/datatable', [FaqController::class, 'datatable'])->name('cms.faq.datatable');
            Route::get('/detail/{id}', [FaqController::class, 'show'])->name('cms.faq.show');
            Route::post('/',[FaqController::class, 'store'])->name('cms.faq.store');
            Route::get('/edit/{id}',[FaqController::class, 'edit'])->name('cms.faq.edit');
            Route::post('/update',[FaqController::class, 'update'])->name('cms.faq.update');
            Route::get('/destroy/{id}',[FaqController::class, 'destroy'])->name('cms.faq.destroy');
        });

        Route::prefix('dokumen')->group(function(){
            Route::get('/', [DokumenController::class, 'index'])->name('cms.dokumen.index');
            Route::get('/datatable', [DokumenController::class, 'datatable'])->name('cms.dokumen.datatable');
            Route::get('/detail/{id}', [DokumenController::class, 'show'])->name('cms.dokumen.show');
            Route::post('/',[DokumenController::class, 'store'])->name('cms.dokumen.store');
            Route::get('/edit/{id}',[DokumenController::class, 'edit'])->name('cms.dokumen.edit');
            Route::post('/update',[DokumenController::class, 'update'])->name('cms.dokumen.update');
            Route::get('/destroy/{id}',[DokumenController::class, 'destroy'])->name('cms.dokumen.destroy');
        });

        Route::prefix('anggota-pelaksana')->group(function(){
            Route::get('/', [AnggotaPelaksanaController::class, 'index'])->name('cms.anggota-pelaksana.index');
            Route::get('/datatable', [AnggotaPelaksanaController::class, 'datatable'])->name('cms.anggota-pelaksana.datatable');
            Route::get('/detail/{id}', [AnggotaPelaksanaController::class, 'show'])->name('cms.anggota-pelaksana.show');
            Route::post('/',[AnggotaPelaksanaController::class, 'store'])->name('cms.anggota-pelaksana.store');
            Route::get('/edit/{id}',[AnggotaPelaksanaController::class, 'edit'])->name('cms.anggota-pelaksana.edit');
            Route::post('/update',[AnggotaPelaksanaController::class, 'update'])->name('cms.anggota-pelaksana.update');
            Route::get('/destroy/{id}',[AnggotaPelaksanaController::class, 'destroy'])->name('cms.anggota-pelaksana.destroy');
        });
    });

    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('master-data')->group(function(){
            Route::prefix('jabatan')->group(function(){
                Route::get('/', [JabatanController::class, 'index'])->name('cms.master-data.jabatan.index');
                Route::get('/datatable', [JabatanController::class, 'datatable'])->name('cms.master-data.jabatan.datatable');
                Route::get('/detail/{id}', [JabatanController::class, 'show'])->name('cms.master-data.jabatan.show');
                Route::post('/',[JabatanController::class, 'store'])->name('cms.master-data.jabatan.store');
                Route::get('/edit/{id}',[JabatanController::class, 'edit'])->name('cms.master-data.jabatan.edit');
                Route::post('/update',[JabatanController::class, 'update'])->name('cms.master-data.jabatan.update');
                Route::get('/destroy/{id}',[JabatanController::class, 'destroy'])->name('cms.master-data.jabatan.destroy');
            });
        });
    });
});
