<?php

use App\Http\Controllers\Dashboard;
use App\Http\Livewire\Admin\User\ListUsers;
use App\Http\Livewire\Setting\ListCurrency;
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
});

