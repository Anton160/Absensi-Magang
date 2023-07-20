<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('redirect');

Route::get('/userLogin',[\App\Http\Controllers\UserLogin::class,'UserAccount'])->middleware('guest')->name('login')->withoutMiddleware('auth');
Route::post('/userLogin',[\App\Http\Controllers\UserLogin::class,'Authenticate']);
Route::get('/logout',[\App\Http\Controllers\UserLogin::class,'logout']);




Route::middleware('banned')->group(function () {
Route::get('/dashboard',[\App\Http\Controllers\Dashboard::class,'Dashboard'])->middleware('auth');
Route::get('/user-account',[\App\Http\Controllers\UserAccount::class,'index'])->middleware('auth');
Route::get('/user-account/create',[\App\Http\Controllers\UserAccount::class,'create'])->middleware('auth');
Route::post('/user-account',[\App\Http\Controllers\UserAccount::class,'store'])->middleware('auth');
Route::get('/user-account/edit/{user}',[\App\Http\Controllers\UserAccount::class,'edit'])->middleware('auth');
Route::get('/user-account/detail/{user}',[\App\Http\Controllers\DetailUserForAdmin::class,'detail'])->middleware('auth');
Route::delete('/userdelete/{user}',[\App\Http\Controllers\UserAccount::class,'destroy'])->middleware('auth');
Route::put('/user-account/{user}',[\App\Http\Controllers\UserAccount::class,'update'])->middleware('auth');
Route::get('/user-account/detail/absen/{attendance}',[\App\Http\Controllers\DetailUserForAdmin::class,'detailAbsen'])->middleware('auth');
Route::put('/user-account/edit/absen/{attendance}',[\App\Http\Controllers\DetailUserForAdmin::class,'update'])->middleware('auth');
Route::get('/user-account/download/{user}',[\App\Http\Controllers\ExportController::class,'exportToExcel'])->middleware('auth');
Route::get('/user-absen',[\App\Http\Controllers\UserAbsen::class,'absen'])->middleware('checkIn','holiday','auth');
Route::post('/user-absen',[\App\Http\Controllers\UserAbsen::class,'store'])->middleware('auth');
Route::get('/user-absen/detail/{attendance}',[\App\Http\Controllers\UserAbsen::class,'detail'])->middleware('auth');
Route::get('/user-profile',[\App\Http\Controllers\Dashboard::class,'profile'])->middleware('auth');
Route::get('/user-profile/edit/{user}',[\App\Http\Controllers\Dashboard::class,'edit'])->middleware('auth');
Route::put('/user-profile/edit/{user}',[\App\Http\Controllers\Dashboard::class,'update'])->middleware('auth');



Route::get('/check-out',[\App\Http\Controllers\UserAbsen::class,'check_out'])->middleware('auth');
Route::put('/check-out',[\App\Http\Controllers\UserAbsen::class,'submitCheckout'])->middleware('auth');


});






Route::get('/test',[\App\Http\Controllers\Test::class,'test']);
