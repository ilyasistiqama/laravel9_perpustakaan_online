<?php

use App\Http\Controllers\ApprovePeminjamanPengembalianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberBukuController;
use App\Http\Controllers\MemberController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyRoleMiddleware;
use Illuminate\Support\Facades\Route;

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
Route::middleware([OnlyGuestMiddleware::class])->group(function(){
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::controller(AuthController::class)->group(function(){
        Route::post('/login', 'doLogin')->name('doLogin');
        Route::post('/register', 'doRegister')->name('doRegister');
    });
});

Route::group(['middleware' => ['role:admin|member'], 'middleware' => OnlyRoleMiddleware::class], function(){
    
    Route::get('/logout', [AuthController::class, 'doLogout'])->name('doLogout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => ['role:admin'], 'prefix' => '/admin'], function(){
        /*                                      MASTER KATEGORI BUKU                                        */
        Route::view('/master-kategori-buku', 'pages.admin.master-kategori-buku', ['menu' => 'admin-master-kategori-buku'])->name('admin.master-kategori-buku');
        Route::controller(KategoriController::class)->group(function(){
            Route::get('/ajax/datatable-kategori', 'dataTableKategori');
            Route::post('ajax/tambah-kategori', 'doAdd');
            Route::post('ajax/edit-kategori', 'doEdit');
            Route::post('ajax/hapus-kategori', 'doDelete');
            Route::post('ajax/get-buku-from-jenis-kategori', 'getBukuFromJenisKategori');
        });
        /*                                      MASTER KATEGORI BUKU                                        */

        /*                                      MASTER  BUKU                                                */
        Route::controller(BukuController::class)->group(function(){
            Route::get('/master-buku', 'index')->name('admin.master-buku');
            Route::get('/master-tambah-buku', 'create')->name('admin.master-create-buku');
            Route::get('/master-detail-buku/{id}', 'show')->name('admin.master-detail-buku');
            Route::get('/master-edit-buku/{id}', 'edit')->name('admin.master-edit-buku');
            Route::post('/master-store-buku', 'doStore')->name('admin.master-store-buku');
            Route::post('/master-update-buku/{id}', 'doUpdate')->name('admin.master-update-buku');
            Route::post('/master-hapus-buku', 'doDelete')->name('admin.master-delete-buku');
            Route::post('/master-import-buku', 'doImport')->name('admin.master-import-buku');
            Route::get('/master-export-buku', 'exportExcel')->name('admin.master-export-buku');
            Route::get('/master-export-pdf-buku/{id}', 'exportPDF')->name('admin.master-export-pdf-buku');
            Route::get('/master-template-import-buku', 'TemplateImportExcel')->name('admin.master-template-import-buku');
            

        });
        /*                                      MASTER  BUKU                                                */
        
        /*                                      MEMBER                                                     */
        Route::view('/member', 'pages.admin.member', ['menu' => 'admin-member'])->name('admin.member');
        Route::controller(MemberController::class)->group(function(){
            Route::get('/ajax/datatable-member', 'datatableMember');
        });
        /*                                      MEMBER                                                     */


        /*                                      PEMINJAMAN BUKU                                                     */
        Route::view('/peminjaman-buku', 'pages.admin.peminjaman-buku', ['menu' => 'admin-peminjaman-buku'])->name('admin.peminjaman-buku');
        Route::controller(ApprovePeminjamanPengembalianController::class)->group(function(){
            Route::get('/ajax/datatable-peminjaman', 'datatablePeminjaman');
            Route::post('/ajax/approve/pinjam-buku', 'approvePeminjaman');
        });
        /*                                      PEMINJAMAN BUKU                                                     */
        
        /*                                      DENDA                                                     */
        Route::view('/denda', 'pages.admin.denda', ['menu' => 'admin-denda'])->name('admin.dendam');
        Route::controller(ApprovePeminjamanPengembalianController::class)->group(function(){
            Route::get('/ajax/datatable-denda', 'datatableDenda');
            Route::post('/ajax/approve/denda', 'approveDenda');
        });
        /*                                      DENDA                                                     */
    });
    
    Route::group(['middleware' => ['role:member'], 'prefix' => '/member'], function(){
        Route::view('/list-buku', 'pages.member.list-buku', ['menu' => 'list-buku'])->name('member.list-buku');
        Route::controller(MemberBukuController::class)->group(function(){
            Route::get('/ajax/datatable-member-buku', 'datatableMemberBuku');
            Route::get('/ajax/get-detail-buku-from-member', 'getDetailBuku');
            Route::post('/ajax/pinjam-buku', 'doPinjam');
            Route::get('/ajax/datatable-member-peminjaman', 'datatableMemberPeminjaman');
            Route::get('/ajax/check-pengembalian-telat', 'checkPengembalianTelat');
            Route::post('/ajax/kembalikan-buku', 'doKembalikan');
            Route::get('/ajax/datatable-member-pengembalian', 'datatableMemberPengembalian');
        });
    });

});
