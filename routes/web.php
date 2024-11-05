<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Profile;
use App\Livewire\Home;
use App\Livewire\Stok\StockManagement;
use App\Livewire\Supplier\SupplierIndex;
use App\Livewire\BarangMasuk\BarangMasukIndex;
use App\Livewire\Menu\MenuManager; // Perbaikan di sini
use App\Livewire\Customer\Index as CustomerIndex;
use App\Livewire\Transaksi\Index as TransaksiIndex;
use App\Livewire\Transaksi\Actions as TransaksiActions;
use App\Livewire\Transaksi\Export as TransaksiExport;
use App\Livewire\Transaksi\Cetak as TransaksiCetak;
use App\Livewire\SuratJalan\SuratJalanComponent;
use Illuminate\Support\Facades\Route;

// Redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Surat Jalan
Route::get('/suratjalan', SuratJalanComponent::class)->name('suratjalan.index');

// Routes untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard & Profile
    Route::get('/home', Home::class)->name('home');
    Route::get('/profile', Profile::class)->name('profile');
    
    // Menu Management
    Route::get('/menu', MenuManager::class)->name('menu.index'); // Perbaikan di sini
    
    // Customer Management
    Route::get('/customer', CustomerIndex::class)->name('customer.index');
    
    // Supplier Management
    Route::get('/supplier', SupplierIndex::class)->name('supplier.index');
    
    // Barang Masuk
    Route::get('/barang-masuk', BarangMasukIndex::class)->name('barang-masuk.index');
    
    // Stock Management
    Route::get('/stok', StockManagement::class)->name('stok.index');
    
    // Transaksi Management
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', TransaksiIndex::class)->name('index');
        Route::get('/create', TransaksiActions::class)->name('create');
        Route::get('/export', TransaksiExport::class)->name('export');
        Route::get('/{transaksi}/edit', TransaksiActions::class)->name('edit');
        Route::get('/{transaksi}/cetak', TransaksiCetak::class)->name('cetak');
    });
});
