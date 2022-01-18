<?php

use App\Http\Controllers\SangridController;
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
//     return view('sangrid', [
//         "title" => "Sangrid CRUD"
//     ]);
// });

// khusus php 7.4 ke atas
// Route::get('/', fn () => view('sangrid', [
//         "title" => "Sangrid CRUD"
//     ])
// );

// Route::get('/', [SangridController::class, 'index'] );
// Route::post('/', [SangridController::class, 'index'] );
Route::match(['get','post'], '/', [SangridController::class, 'index'] );
Route::get('/SangridController/tampilMaster', [SangridController::class, 'tampilMaster'] );
// Route::match(['get','post'] ,'/SangridController/tampilMaster', [SangridController::class, 'tampilMaster'] );

Route::get('/welcome', function () {
    return view('welcome');
});
