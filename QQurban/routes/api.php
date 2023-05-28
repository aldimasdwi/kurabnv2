<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\admin;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\KurbanController;
use App\Http\Controllers\OrderGrupController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/profil',[CobaController::class,'profil']);


// Route::post('/register',[HomeController::class,'register'])->name('login');

// Route::post('/login', [HomeController::class, 'register']);


Route::post('/register',[CobaController::class,'register']);
Route::post('/token', [CobaController::class, 'otp']);
Route::post('/login', [CobaController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [CobaController::class, 'logout']);
    Route::post('/user', [CobaController::class, 'user']);

    //pesan
    Route::post('/pesan', [PesanController::class, 'pesan']);;

    //order
    Route::post('/order',[OrderController::class, 'order']);
    Route::get('/tampilanuser', [OrderController::class, 'tampilanuser']);

    //ordergrup
    Route::post('/storeordergrup',[OrderGrupController::class, 'store']);
    Route::get('/tampilkanordergrup', [OrderGrupController::class, 'tampilkan']);
    Route::post('/patunganordergrup/{id}', [OrderGrupController::class, 'patungan']);

    Route::get('/semuakurbanuser', [KurbanController::class, 'tampilkan']);

});


Route::middleware(['auth:sanctum', 'admin'])->group(function (){

    Route::post('/logout', [CobaController::class, 'logout']);

    //pesan
    Route::get('/semuapesan', [PesanController::class, 'semuapesan']);
    Route::get('/deletepesan/{id}', [PesanController::class, 'delete']);


    //kurban
    Route::post('/storekurban',[KurbanController::class, 'storkurban']);
    Route::get('/deletekurbannn/{id}', [KurbanController::class, 'hapus']);
    Route::post('/update/{id}', [KurbanController::class, 'edit']);
    Route::get('/semuakurban', [KurbanController::class, 'tampilkan']);

    //order
    Route::post('/status/{id}', [OrderController::class, 'status']);
    Route::post('/editorder/{id}', [OrderController::class, 'edit']);
    Route::get('/hapusorder/{id}', [OrderController::class, 'hapus']);
    Route::get('/tampilanadmin', [OrderController::class, 'tampilanadmin']);

    //order grup
    Route::post('/statusordergrup/{id}', [OrderGrupController::class, 'status']);
    Route::get('/hapusordergrup/{id}', [OrderGrupController::class, 'hapus']);
    Route::post('/updateordergrup/{id}', [OrderGrupController::class, 'edit']);
    Route::get('/tampilkanordergrup', [OrderGrupController::class, 'tampilkan']);


});




