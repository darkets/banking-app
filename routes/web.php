<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\TransactionController;
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

Route::get('/dashboard', function () {
    return redirect('accounts');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/accounts', [AccountController::class, 'view'])->name('accounts');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts/create', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/create-investment', [AccountController::class, 'createInvestmentAccount'])->name('accounts.createInvestment');
    Route::delete('/accounts/delete', [AccountController::class, 'delete'])->name('accounts.delete');
    Route::get('/transactions', [TransactionController::class, 'view'])->name('transactions');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/create', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/investments', [InvestmentController::class, 'view'])->name('investments');
    Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    Route::put('/investments/sell', [InvestmentController::class, 'sell'])->name('investments.sell');
});

require __DIR__ . '/auth.php';
