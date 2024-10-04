<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Letter;
use App\Http\Controllers\ContractController;

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
    return view('pdfs/upload');
});

Route::get('/letter', Letter::class)->name('letter');

Route::get('/create-contract', [ContractController::class,'showCreateContractView']);

Route::post('/contracts/create', [ContractController::class,'createAndSaveContract'])->name('create-contract');



// Route::view('/captures/create', '/captures/create');

Route::post('/upload', [UploadController::class, 'upload']);



// Route::get('/create-contract', [ContractController::class,'wordView']);

// Route::post('/contracts/create', [ContractController::class,'wordSave'])->name('word.save');


Route::post('/upload', [PdfController::class, 'uploadAndLock'])->name('upload.lock');