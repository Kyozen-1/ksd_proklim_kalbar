<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\KegiatanController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\DokumenController;
use App\Http\Controllers\Backend\AnggotaPelaksanaController;
use App\Http\Controllers\Backend\LandingPageController;
use App\Http\Controllers\Backend\TimbulanLb3Controller;
use App\Http\Controllers\Backend\KualitasLingkunganController;
use App\Http\Controllers\Backend\JumlahPendudukController;
use App\Http\Controllers\Backend\SampahController;
use App\Http\Controllers\Backend\TargetPenurunanEmisiController;
use App\Http\Controllers\Backend\EmisiController;
use App\Http\Controllers\Backend\ProklimController;
use App\Http\Controllers\Backend\MasterData\JabatanController;
use App\Http\Controllers\Backend\MasterData\SectionLandingPageController;
use App\Http\Controllers\Backend\MasterData\KategoriProklimController;
use App\Http\Controllers\Backend\MasterData\SektorUtamaEmisiController;
use App\Http\Controllers\Backend\MasterData\JenisEmisiController;
use App\Http\Controllers\Backend\MasterData\KategoriSampahController;
use App\Http\Controllers\Backend\MasterData\KategoriKualitasLingkunganController;
use App\Http\Controllers\Backend\MasterData\SektorLb3Controller;
use App\Http\Controllers\Backend\Pengaturan\ApiClientController;
use App\Http\Controllers\Backend\Pengaturan\ApiPermissionController;

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
            Route::get('/gambar/{id}', [BeritaController::class, 'gambar'])->name('cms.berita.gambar');
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
            Route::get('/file/{id}', [DokumenController::class, 'file'])->name('cms.dokumen.file');
        });

        Route::prefix('anggota-pelaksana')->group(function(){
            Route::get('/', [AnggotaPelaksanaController::class, 'index'])->name('cms.anggota-pelaksana.index');
            Route::get('/datatable', [AnggotaPelaksanaController::class, 'datatable'])->name('cms.anggota-pelaksana.datatable');
            Route::get('/detail/{id}', [AnggotaPelaksanaController::class, 'show'])->name('cms.anggota-pelaksana.show');
            Route::post('/',[AnggotaPelaksanaController::class, 'store'])->name('cms.anggota-pelaksana.store');
            Route::get('/edit/{id}',[AnggotaPelaksanaController::class, 'edit'])->name('cms.anggota-pelaksana.edit');
            Route::post('/update',[AnggotaPelaksanaController::class, 'update'])->name('cms.anggota-pelaksana.update');
            Route::get('/destroy/{id}',[AnggotaPelaksanaController::class, 'destroy'])->name('cms.anggota-pelaksana.destroy');
            Route::get('/gambar/{id}', [AnggotaPelaksanaController::class, 'gambar'])->name('cms.anggota-pelaksana.gambar');
        });

        Route::prefix('kegiatan')->group(function(){
            Route::get('/',[KegiatanController::class, 'index'])->name('cms.kegiatan.index');
            Route::get('/create',[KegiatanController::class, 'create'])->name('cms.kegiatan.create');
            Route::get('/datatable',[KegiatanController::class, 'datatable'])->name('cms.kegiatan.datatable');
            Route::post('/',[KegiatanController::class, 'store'])->name('cms.kegiatan.store');
            Route::get('/edit/{id}',[KegiatanController::class, 'edit'])->name('cms.kegiatan.edit');
            Route::post('/update/{id}',[KegiatanController::class, 'update'])->name('cms.kegiatan.update');
            Route::get('/destroy/{id}',[KegiatanController::class, 'destroy'])->name('cms.kegiatan.destroy');
            Route::get('/gambar/{id}', [KegiatanController::class, 'gambar'])->name('cms.kegiatan.gambar');
        });

        Route::prefix('timbulan-lb3')->group(function(){
            Route::get('/', [TimbulanLb3Controller::class, 'index'])->name('cms.timbulan-lb3.index');
            Route::get('/datatable', [TimbulanLb3Controller::class, 'datatable'])->name('cms.timbulan-lb3.datatable');
            Route::post('/', [TimbulanLb3Controller::class, 'store'])->name('cms.timbulan-lb3.store');
            Route::get('/datatable', [TimbulanLb3Controller::class, 'datatable'])->name('cms.timbulan-lb3.datatable');
            Route::post('/update', [TimbulanLb3Controller::class, 'update'])->name('cms.timbulan-lb3.update');
        });

        Route::prefix('kualitas-lingkungan')->group(function(){
            Route::get('/', [KualitasLingkunganController::class, 'index'])->name('cms.kualitas-lingkungan.index');
            Route::get('/datatable', [KualitasLingkunganController::class, 'datatable'])->name('cms.kualitas-lingkungan.datatable');
            Route::post('/', [KualitasLingkunganController::class, 'store'])->name('cms.kualitas-lingkungan.store');
            Route::get('/datatable', [KualitasLingkunganController::class, 'datatable'])->name('cms.kualitas-lingkungan.datatable');
            Route::post('/update', [KualitasLingkunganController::class, 'update'])->name('cms.kualitas-lingkungan.update');
        });

        Route::prefix('jumlah-penduduk')->group(function(){
            Route::get('/', [JumlahPendudukController::class, 'index'])->name('cms.jumlah-penduduk.index');
            Route::get('/datatable', [JumlahPendudukController::class, 'datatable'])->name('cms.jumlah-penduduk.datatable');
            Route::post('/',[JumlahPendudukController::class, 'store'])->name('cms.jumlah-penduduk.store');
            Route::get('/edit/{id}',[JumlahPendudukController::class, 'edit'])->name('cms.jumlah-penduduk.edit');
            Route::post('/update',[JumlahPendudukController::class, 'update'])->name('cms.jumlah-penduduk.update');
        });

        Route::prefix('sampah')->group(function(){
            Route::get('/', [SampahController::class, 'index'])->name('cms.sampah.index');
            Route::get('/datatable', [SampahController::class, 'datatable'])->name('cms.sampah.datatable');
            Route::post('/', [SampahController::class, 'store'])->name('cms.sampah.store');
            Route::get('/datatable', [SampahController::class, 'datatable'])->name('cms.sampah.datatable');
            Route::post('/update', [SampahController::class, 'update'])->name('cms.sampah.update');
        });

        Route::prefix('target-penurunan-emisi')->group(function(){
            Route::get('/', [TargetPenurunanEmisiController::class, 'index'])->name('cms.target-penurunan-emisi.index');
            Route::get('/datatable', [TargetPenurunanEmisiController::class, 'datatable'])->name('cms.target-penurunan-emisi.datatable');
            Route::post('/',[TargetPenurunanEmisiController::class, 'store'])->name('cms.target-penurunan-emisi.store');
            Route::get('/edit/{id}',[TargetPenurunanEmisiController::class, 'edit'])->name('cms.target-penurunan-emisi.edit');
            Route::post('/update',[TargetPenurunanEmisiController::class, 'update'])->name('cms.target-penurunan-emisi.update');
        });

        Route::prefix('emisi')->group(function(){
            Route::get('/', [EmisiController::class, 'index'])->name('cms.emisi.index');
            Route::get('/datatable', [EmisiController::class, 'datatable'])->name('cms.emisi.datatable');
            Route::post('/', [EmisiController::class, 'store'])->name('cms.emisi.store');
            Route::get('/datatable', [EmisiController::class, 'datatable'])->name('cms.emisi.datatable');
            Route::post('/update', [EmisiController::class, 'update'])->name('cms.emisi.update');
        });

        Route::prefix('proklim')->group(function(){
            Route::get('/', [ProklimController::class, 'index'])->name('cms.proklim.index');
            Route::get('/datatable', [ProklimController::class, 'datatable'])->name('cms.proklim.datatable');
            Route::post('/get-kecamatan', [ProklimController::class, 'getKecamatan'])->name('cms.proklim.get-kecamatan');
            Route::post('/get-kelurahan', [ProklimController::class, 'getKelurahan'])->name('cms.proklim.get-kelurahan');
            Route::post('/', [ProklimController::class, 'store'])->name('cms.proklim.store');
            Route::get('/detail/{id}', [ProklimController::class, 'detail'])->name('cms.proklim.detail');
            Route::post('/update', [ProklimController::class, 'update'])->name('cms.proklim.update');
            Route::get('/edit/{id}', [ProklimController::class, 'edit'])->name('cms.proklim.edit');
            Route::get('/destroy/{id}',[ProklimController::class, 'destroy'])->name('cms.proklim.destroy');
        });
    });

    Route::middleware('check_role:superadmin')->group(function(){
        Route::prefix('landing-page')->group(function(){
            Route::get('/', [LandingPageController::class, 'index'])->name('cms.landing-page.index');
            Route::get('/datatable', [LandingPageController::class, 'datatable'])->name('cms.landing-page.datatable');
            Route::get('/create', [LandingPageController::class, 'create'])->name('cms.landing-page.create');
            Route::post('/', [LandingPageController::class, 'store'])->name('cms.landing-page.store');
            Route::get('/edit/{id}', [LandingPageController::class, 'edit'])->name('cms.landing-page.edit');
            Route::post('/update/{id}', [LandingPageController::class, 'update'])->name('cms.landing-page.update');
            Route::get('/destroy/{id}', [LandingPageController::class, 'destroy'])->name('cms.landing-page.destroy');
            Route::get('/gambar/{path}', [LandingPageController::class, 'gambar'])->name('cms.landing-page.gambar');
        });

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

            Route::prefix('section-landing-page')->group(function(){
                Route::get('/', [SectionLandingPageController::class, 'index'])->name('cms.master-data.section-landing-page.index');
                Route::get('/datatable', [SectionLandingPageController::class, 'datatable'])->name('cms.master-data.section-landing-page.datatable');
                Route::get('/detail/{id}', [SectionLandingPageController::class, 'show'])->name('cms.master-data.section-landing-page.show');
                Route::post('/',[SectionLandingPageController::class, 'store'])->name('cms.master-data.section-landing-page.store');
                Route::get('/edit/{id}',[SectionLandingPageController::class, 'edit'])->name('cms.master-data.section-landing-page.edit');
                Route::post('/update',[SectionLandingPageController::class, 'update'])->name('cms.master-data.section-landing-page.update');
                Route::get('/destroy/{id}',[SectionLandingPageController::class, 'destroy'])->name('cms.master-data.section-landing-page.destroy');
            });

            Route::prefix('kategori-proklim')->group(function(){
                Route::get('/', [KategoriProklimController::class, 'index'])->name('cms.master-data.kategori-proklim.index');
                Route::get('/datatable', [KategoriProklimController::class, 'datatable'])->name('cms.master-data.kategori-proklim.datatable');
                Route::get('/detail/{id}', [KategoriProklimController::class, 'show'])->name('cms.master-data.kategori-proklim.show');
                Route::post('/',[KategoriProklimController::class, 'store'])->name('cms.master-data.kategori-proklim.store');
                Route::get('/edit/{id}',[KategoriProklimController::class, 'edit'])->name('cms.master-data.kategori-proklim.edit');
                Route::post('/update',[KategoriProklimController::class, 'update'])->name('cms.master-data.kategori-proklim.update');
                Route::get('/destroy/{id}',[KategoriProklimController::class, 'destroy'])->name('cms.master-data.kategori-proklim.destroy');
            });

            Route::prefix('sektor-utama-emisi')->group(function(){
                Route::get('/', [SektorUtamaEmisiController::class, 'index'])->name('cms.master-data.sektor-utama-emisi.index');
                Route::get('/datatable', [SektorUtamaEmisiController::class, 'datatable'])->name('cms.master-data.sektor-utama-emisi.datatable');
                Route::get('/detail/{id}', [SektorUtamaEmisiController::class, 'show'])->name('cms.master-data.sektor-utama-emisi.show');
                Route::post('/',[SektorUtamaEmisiController::class, 'store'])->name('cms.master-data.sektor-utama-emisi.store');
                Route::get('/edit/{id}',[SektorUtamaEmisiController::class, 'edit'])->name('cms.master-data.sektor-utama-emisi.edit');
                Route::post('/update',[SektorUtamaEmisiController::class, 'update'])->name('cms.master-data.sektor-utama-emisi.update');
                Route::get('/destroy/{id}',[SektorUtamaEmisiController::class, 'destroy'])->name('cms.master-data.sektor-utama-emisi.destroy');
            });

            Route::prefix('jenis-emisi')->group(function(){
                Route::get('/', [JenisEmisiController::class, 'index'])->name('cms.master-data.jenis-emisi.index');
                Route::get('/datatable', [JenisEmisiController::class, 'datatable'])->name('cms.master-data.jenis-emisi.datatable');
                Route::get('/detail/{id}', [JenisEmisiController::class, 'show'])->name('cms.master-data.jenis-emisi.show');
                Route::post('/',[JenisEmisiController::class, 'store'])->name('cms.master-data.jenis-emisi.store');
                Route::get('/edit/{id}',[JenisEmisiController::class, 'edit'])->name('cms.master-data.jenis-emisi.edit');
                Route::post('/update',[JenisEmisiController::class, 'update'])->name('cms.master-data.jenis-emisi.update');
                Route::get('/destroy/{id}',[JenisEmisiController::class, 'destroy'])->name('cms.master-data.jenis-emisi.destroy');
            });

            Route::prefix('kategori-sampah')->group(function(){
                Route::get('/', [KategoriSampahController::class, 'index'])->name('cms.master-data.kategori-sampah.index');
                Route::get('/datatable', [KategoriSampahController::class, 'datatable'])->name('cms.master-data.kategori-sampah.datatable');
                Route::get('/detail/{id}', [KategoriSampahController::class, 'show'])->name('cms.master-data.kategori-sampah.show');
                Route::post('/',[KategoriSampahController::class, 'store'])->name('cms.master-data.kategori-sampah.store');
                Route::get('/edit/{id}',[KategoriSampahController::class, 'edit'])->name('cms.master-data.kategori-sampah.edit');
                Route::post('/update',[KategoriSampahController::class, 'update'])->name('cms.master-data.kategori-sampah.update');
                Route::get('/destroy/{id}',[KategoriSampahController::class, 'destroy'])->name('cms.master-data.kategori-sampah.destroy');
            });

            Route::prefix('kategori-kualitas-lingkungan')->group(function(){
                Route::get('/', [KategoriKualitasLingkunganController::class, 'index'])->name('cms.master-data.kategori-kualitas-lingkungan.index');
                Route::get('/datatable', [KategoriKualitasLingkunganController::class, 'datatable'])->name('cms.master-data.kategori-kualitas-lingkungan.datatable');
                Route::get('/detail/{id}', [KategoriKualitasLingkunganController::class, 'show'])->name('cms.master-data.kategori-kualitas-lingkungan.show');
                Route::post('/',[KategoriKualitasLingkunganController::class, 'store'])->name('cms.master-data.kategori-kualitas-lingkungan.store');
                Route::get('/edit/{id}',[KategoriKualitasLingkunganController::class, 'edit'])->name('cms.master-data.kategori-kualitas-lingkungan.edit');
                Route::post('/update',[KategoriKualitasLingkunganController::class, 'update'])->name('cms.master-data.kategori-kualitas-lingkungan.update');
                Route::get('/destroy/{id}',[KategoriKualitasLingkunganController::class, 'destroy'])->name('cms.master-data.kategori-kualitas-lingkungan.destroy');
            });

            Route::prefix('sektor-lb3')->group(function(){
                Route::get('/', [SektorLb3Controller::class, 'index'])->name('cms.master-data.sektor-lb3.index');
                Route::get('/datatable', [SektorLb3Controller::class, 'datatable'])->name('cms.master-data.sektor-lb3.datatable');
                Route::get('/detail/{id}', [SektorLb3Controller::class, 'show'])->name('cms.master-data.sektor-lb3.show');
                Route::post('/',[SektorLb3Controller::class, 'store'])->name('cms.master-data.sektor-lb3.store');
                Route::get('/edit/{id}',[SektorLb3Controller::class, 'edit'])->name('cms.master-data.sektor-lb3.edit');
                Route::post('/update',[SektorLb3Controller::class, 'update'])->name('cms.master-data.sektor-lb3.update');
                Route::get('/destroy/{id}',[SektorLb3Controller::class, 'destroy'])->name('cms.master-data.sektor-lb3.destroy');
            });
        });

        Route::prefix('pengaturan')->group(function(){
            Route::prefix('api-client')->group(function(){
                Route::get('/', [ApiClientController::class, 'index'])->name('cms.pengaturan.api-client.index');
                Route::get('/datatable', [ApiClientController::class, 'datatable'])->name('cms.pengaturan.api-client.datatable');
                Route::post('/',[ApiClientController::class, 'store'])->name('cms.pengaturan.api-client.store');
                Route::post('/regenerate', [ApiClientController::class, 'regenerate'])->name('cms.pengaturan.api-client.regenarate');
                Route::get('/destroy/{id}',[ApiClientController::class, 'destroy'])->name('cms.pengaturan.api-client.destroy');
                Route::get('/permissions/{id}', [ApiClientController::class, 'permissions'])->name('cms.pengaturan.api-client.permissions');
                Route::post('/permissions/{id}',[ApiClientController::class, 'updatePermissions'])->name('cms.pengaturan.api-client.update-permissions');
            });

            Route::prefix('api-permission')->group(function(){
                Route::get('/', [ApiPermissionController::class, 'index'])->name('cms.pengaturan.api-permission.index');
                Route::post('/',[ApiPermissionController::class, 'store'])->name('cms.pengaturan.api-permission.store');
                Route::post('/sync',[ApiPermissionController::class, 'sync'])->name('cms.pengaturan.api-permission.sync');
                Route::get('/datatable', [ApiPermissionController::class, 'datatable'])->name('cms.pengaturan.api-permission.datatable');
                Route::get('/create', [ApiPermissionController::class, 'create'])->name('cms.pengaturan.api-permission.create');
                Route::get('/detail/{id}', [ApiPermissionController::class, 'show'])->name('cms.pengaturan.api-permission.show');
                Route::get('/edit/{id}',[ApiPermissionController::class, 'edit'])->name('cms.pengaturan.api-permission.edit');
                Route::post('/update/{id}',[ApiPermissionController::class, 'update'])->name('cms.pengaturan.api-permission.update');
                Route::get('/destroy/{id}',[ApiPermissionController::class, 'destroy'])->name('cms.pengaturan.api-permission.destroy');
                Route::get('/activate/{id}',[ApiPermissionController::class, 'activate'])->name('cms.pengaturan.api-permission.activate');
            });
        });
    });
});
