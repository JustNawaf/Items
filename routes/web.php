<?php

use App\Http\Controllers\ItemController;
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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::get('/',[ItemController::class,'index'])->name('index');
    Route::post('/add/item',[ItemController::class,'addItem'])->name('addItem');
    Route::post('/update/item',[ItemController::class,'updateItem'])->name('addItem');


});
