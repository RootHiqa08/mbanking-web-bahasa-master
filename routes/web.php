<?php

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\TransactionsController;

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::post('/users_change', [LoginController::class, 'edit_users'])->name('users_change');
	Route::get('/users_delete/{users_id}', [LoginController::class, 'delete_users'])->name('users_delete');
	
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
	Route::get('/admin', [TransactionsController::class, 'admin'])->name('admin');
	Route::get('/verif/{users_id}', [TransactionsController::class, 'verif'])->name('verif');

	Route::get('/transaction', [TransactionsController::class, 'show'])->name('transaction');
	Route::post('/transaction_card', [TransactionsController::class, 'card'])->name('card_check');
	Route::post('/transfer', [TransactionsController::class, 'transfer'])->name('transfer');
	Route::get('/saldo', [TransactionsController::class, 'show_saldo'])->name('saldo');
	Route::post('/topup', [TransactionsController::class, 'topup'])->name('topup');
	
});