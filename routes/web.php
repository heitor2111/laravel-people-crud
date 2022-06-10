<?php

use App\Http\Controllers\PersonController;
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

Route::get('/', [PersonController::class, 'index'])->name('personHome');
Route::get('/person/create', [PersonController::class, 'create'])->name('personCreate');
Route::get('/person/{id}', [PersonController::class, 'show'])->name('personShow');
Route::get('/person/{id}/edit', [PersonController::class, 'edit'])->name('personEdit');
Route::get('/person/{id}/delete', [PersonController::class, 'delete'])->name('personDelete');

Route::post('store', [PersonController::class, 'store'])->name('personStore');
Route::put('update', [PersonController::class, 'update'])->name('personUpdate');
