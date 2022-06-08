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

Route::get('/', [PersonController::class, 'index']);
Route::get('/create', [PersonController::class, 'create']);
Route::get('/{id}', [PersonController::class, 'show']);
Route::get('/{id}/edit', [PersonController::class, 'edit']);
