<?php

use App\Http\Controllers\TableXmlController;
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

Route::get('/',[TableXmlController::class, 'index'])->name('index');

Route::post('/store', [TableXmlController::class, 'store'])->name('order.store');
