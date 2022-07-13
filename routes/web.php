<?php

// use App\Http\Controllers\Dashboard;
use App\Http\Livewire\Admin\User\ListUsers;
use App\Http\Livewire\Cash\AddCash;
use App\Http\Livewire\Cash\AddPayment;
use App\Http\Livewire\Cash\EditCash;
use App\Http\Livewire\Cash\EditExchange;
use App\Http\Livewire\Cash\EditPayment;
use App\Http\Livewire\Cash\Exchange;
use App\Http\Livewire\Cash\ListCashdrawer;
use App\Http\Livewire\Cash\ListCashTransactions;
use App\Http\Livewire\Customer\ListCustomer;
use App\Http\Livewire\Dashboard;
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
    // Route::get('dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('setting/users', ListUsers::class)->name('setting.users');
    Route::get('setting/currencies', ListCurrency::class)->name('setting.currencies');
    Route::get('setting/depatments', ListDepatment::class)->name('setting.depatments');
    Route::get('setting/items', ListItems::class)->name('setting.items');

    // Payment Rout
    Route::get('cash/cashdrawers', ListCashdrawer::class)->name('cash.cashdrawers');
    Route::get('cash/cashtransactions', ListCashTransactions::class)->name('cash.cashtransactions');
    Route::get('cash/addcash', AddCash::class)->name('cash.addcash');
    Route::get('cash/{transaction}/editcash', EditCash::class)->name('cash.editcash');

    Route::get('cash/newexpand', AddPayment::class)->name('cash.newexpand');
    Route::get('cash/{transaction}editexpand', EditPayment::class)->name('cash.editexpand');

    Route::get('cash/exchange', Exchange::class)->name('cash.exchange');
    Route::get('cash/{transaction}editexchange', EditExchange::class)->name('cash.editexchange');

    // Customers
    Route::get('customer/list', ListCustomer::class)->name('customer.list');


});

