<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\FotografiController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PesanPaketController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\VideografiController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PemesananVideografiController; // Tambahkan import controller baru
use App\Http\Controllers\PemesananPromoController; // Tambahkan import controller PemesananPromoController

Auth::routes();

// Landing page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
Route::get('/paketpromo', [LandingPageController::class, 'promo'])->name('promo');
Route::get('/promo/{id}', [LandingPageController::class, 'show'])->name('promo.detail');
Route::post('ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
Route::get('/paket', [PesanPaketController::class, 'index'])->name('paket.index');
Route::post('/promo/delete-expired', [PromoController::class, 'deleteExpired'])->name('promo.deleteExpired');


// Route untuk update profil
Route::put('/profile/update/{id}', [UserController::class, 'updateProfile'])->name('profile.update');

// Rute dengan autentikasi

Route::middleware(['auth'])->group(function () {
    // Rute untuk Admin
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        Route::get('/profile', [UserController::class, 'profileAdmin'])->name('profile.admin');
        Route::resource('videografi', VideografiController::class);
        Route::resource('fotografi', FotografiController::class);
        Route::get('/pemesanan/videografi', [PemesananVideografiController::class, 'adminIndex'])->name('admin.pemesanan.videografi.index');
        Route::get('/pemesanan', [PemesananController::class, 'indexAdmin'])->name('admin.pemesanan.index');
         Route::get('/pemesanan/promo',[PemesananPromoController::class, 'adminIndex'])->name('admin.pemesanan.promo.index');
        Route::post('/videografer/assign/{id}', [PemesananVideografiController::class, 'assignFotografer'])->name('videografi.assign');
        Route::post('/fotografer/assign/{id}', [PemesananController::class, 'assignFotografer'])->name('fotografer.assign');
        Route::resource('promo', PromoController::class);
        Route::get('ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
        Route::post('/ulasan/{id}/sembunyikan', [UlasanController::class, 'sembunyikan'])->name('ulasan.sembunyikan');
        Route::post('/reminder/videografi', [PemesananVideografiController::class, 'sendReminder'])->name('reminder.videografi');
        Route::resource('portofolio', PortofolioController::class);
        Route::get('/dokumentasi/fotografi', [DokumentasiController::class, 'indexFotografi'])->name('dokumentasi.fotografi');
        Route::get('/dokumentasi/promo', [DokumentasiController::class, 'indexPromo'])->name('dokumentasi.promo');
        Route::get('/dokumentasi/videografi', [DokumentasiController::class, 'indexVideografi'])->name('dokumentasi.videografi');

// Route untuk reminder pemesanan promo
        Route::post('/reminder/promo', [PemesananPromoController::class, 'sendReminder'])->name('reminder.promo');

// Route untuk reminder pemesanan biasa
        Route::post('/reminder', [PemesananController::class, 'sendReminder'])->name('reminder.pemesanan');
        // Rute untuk Pemesanan Promo
        Route::get('/pemesanan/promo', [PemesananPromoController::class, 'adminIndex'])->name('admin.pemesanan.promo.index');
        Route::post('/pemesanan/promo/assign/{id}', [PemesananPromoController::class, 'assignFotografer'])->name('admin.pemesanan.promo.assign');
    });

    // Rute untuk Fotografer
    Route::middleware(['role:fotografer'])->prefix('fotografer')->group(function () {
        Route::get('/fotografi', [KaryawanController::class, 'pemesananFotografi'])->name('fotografer.fotografi');
        Route::get('/videografi', [KaryawanController::class, 'pemesananVideografi'])->name('fotografer.videografi');
        Route::get('/promo', [KaryawanController::class, 'pemesananPromo'])->name('fotografer.promo');
        Route::put('/pemesanan/{id}/update-link-dokumentasi/{tipe}', [KaryawanController::class, 'updateLinkDokumentasi'])->name('pemesanan.updateLinkDokumentasi');
        Route::put('/pemesanan/videografi/{id}/update-link-dokumentasi/{tipe}', [KaryawanController::class, 'updateLinkDokumentasi'])->name('pemesanan.videografi.updateLinkDokumentasi');
        Route::get('/profile', [UserController::class, 'profileFotografer'])->name('profile.fotografer');
        Route::put('/pemesanan/{id}/input-code-foto/{tipe}', [KaryawanController::class, 'inputCodeFoto'])->name('pemesanan.inputCodeFoto');
    });

    // Rute untuk Custome 
    
    Route::middleware(['role:customer'])->prefix('customer')->group(function () {
        // Rute Pemesanan Videografi
        Route::prefix('videografi')->group(function () {
            Route::get('/profile/customer', [UserController::class, 'profileCustomer'])->name('profile.customer');
            Route::get('/{videografi}/create', [PemesananVideografiController::class, 'create'])->name('pemesanans.videografi.create');
            Route::post('/store', [PemesananVideografiController::class, 'store'])->name('pemesanans.videografi.store');
            Route::get('/', [PemesananVideografiController::class, 'index'])->name('pemesanans.videografi.index');
            Route::put('/{id}/ubah-jadwal', [PemesananVideografiController::class, 'ubahJadwal'])->name('pemesanans.videografi.ubahJadwal');
            Route::delete('/{id}', [PemesananVideografiController::class, 'destroy'])->name('pemesanans.videografi.destroy');
            Route::get('/{pemesanan}/bayar', [PemesananVideografiController::class, 'bayar'])->name('pemesananvideografi.bayar');
            Route::post('/pemesanans/videografi/{id}/kode-foto', [PemesananVideografiController::class, 'masukkanKodeFoto'])->name('pemesanans.videografi.kode_foto');
        });

        // Rute Pemesanan Umum
        Route::prefix('pemesanan')->group(function () {
            Route::get('/', [PemesananController::class, 'index'])->name('pemesanans.index');
            Route::post('/store', [PemesananController::class, 'store'])->name('pemesanans.store');
            Route::get('/create/{id}', [PemesananController::class, 'create'])->name('pemesanans.create');
            Route::put('/{id}/ubah-jadwal', [PemesananController::class, 'ubahJadwal'])->name('pemesanans.ubahJadwal');
            Route::delete('/{id}', [PemesananController::class, 'destroy'])->name('pemesanans.destroy');
            Route::get('/{pemesanan}/bayar', [PemesananController::class, 'bayar'])->name('pemesanans.bayar');
            Route::post('/pemesanans/{id}/kode-foto', [PemesananController::class, 'masukkanKodeFoto'])->name('pemesanans.kode_foto');
        });

        // Rute Detail Fotografi dan Videografi
        Route::get('/fotografi/{id}/detail', [LandingPageController::class, 'showFotografi'])->name('fotografi.detail');
        Route::get('/videografi/{id}/detail', [LandingPageController::class, 'showVideografi'])->name('videografi.detail');

        // Rute Pemesanan Promo
        Route::prefix('pemesanan-promo')->group(function () {
            Route::get('/', [PemesananPromoController::class, 'index'])->name('pemesanans.promo.index');
            Route::get('/create/{id}', [PemesananPromoController::class, 'create'])->name('pemesanans.promo.create');
            Route::post('/store', [PemesananPromoController::class, 'store'])->name('pemesanans.promo.store');
            Route::put('/{id}/ubah-jadwal', [PemesananPromoController::class, 'ubahJadwal'])->name('pemesanans.promo.ubahJadwal');
            Route::delete('/{id}', [PemesananPromoController::class, 'destroy'])->name('pemesanans.promo.destroy');
            Route::get('/{pemesanan}/bayar', [PemesananPromoController::class, 'bayar'])->name('pemesanans.promo.bayar');
            Route::post('/pemesanans/promo/{id}/kode-foto', [PemesananPromoController::class, 'masukkanKodeFoto'])->name('pemesanans.promo.kode_foto');
        });
    });
});
