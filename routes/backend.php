<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BeritaController;

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
    });
});
