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
Route::get('/SangridController/formCreate', [SangridController::class, 'formCreate'] );
// Route::post('/SangridController/insertJqgrid/{id}', [SangridController::class, 'insertJqgrid'] );
Route::match(['get','post'], '/SangridController/insertJqgrid/{id}', [SangridController::class, 'insertJqgrid'] );
Route::match(['get','post'], '/SangridController/selectJqgrid/{id}', [SangridController::class, 'selectJqgrid'] );
// Route::get('/SangridController/formDetail/{id}', [SangridController::class, 'formDetail/{id}'] );
Route::match(['get','post'], '/SangridController/formDetail/{id}', [SangridController::class, 'formDetail'] );

Route::match(['get','post'], '/SangridController/formEdit/{id}', [SangridController::class, 'formEdit'] );
Route::match(['get','post'], '/SangridController/updateJqgrid/{id}', [SangridController::class, 'updateJqgrid'] );

Route::match(['get','post'], '/SangridController/formDelete/{id}', [SangridController::class, 'formDelete'] );
Route::match(['get','post'], '/SangridController/deleteJqgrid/{id}', [SangridController::class, 'deleteJqgrid'] );

Route::get('/welcome', function () {
    return view('welcome');
});
