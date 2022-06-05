<?php

use App\Http\Controllers\Dashboard;
use App\Http\Livewire\Admin\User\ListUsers;
use App\Http\Livewire\Pament\AddCash;
use App\Http\Livewire\Pament\ListCashdrawer;
use App\Http\Livewire\Pament\ListCashTransactions;
use App\Http\Livewire\Setting\ListCurrency;
use App\Http\Livewire\Setting\ListDepatment;
use App\Http\Livewire\Setting\ListItems;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('setting/users', ListUsers::class)->name('setting.users');
    Route::get('setting/currencies', ListCurrency::class)->name('setting.currencies');
    Route::get('setting/depatments', ListDepatment::class)->name('setting.depatments');
    Route::get('setting/items', ListItems::class)->name('setting.items');

    // Payment Rout
    Route::get('payment/cashdrawers', ListCashdrawer::class)->name('payment.cashdrawers');
    Route::get('payment/cashtransactions', ListCashTransactions::class)->name('payment.cashtransactions');
    Route::get('payment/addcash', AddCash::class)->name('payment.addcash');
});

