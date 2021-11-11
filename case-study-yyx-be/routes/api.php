<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'user'], function(){
    Route::post('/auto-login', [UserController::class, 'autoLogin']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
});

Route::group(['prefix'=>'employee'], function(){
    Route::get('/get-all/{filterKeyword?}', [EmployeeController::class, 'getAll']);
    Route::get('/get-all-deleted', [EmployeeController::class, 'getAllDeleted']);
    Route::get('/get-one/{id}', [EmployeeController::class, 'getOne']);
    Route::post('/create', [EmployeeController::class, 'create']);
    Route::post('/edit/{id}', [EmployeeController::class, 'edit']);
    Route::get('/delete/{id}', [EmployeeController::class, 'delete']);
    Route::get('/assigned-addresses/{id}', [EmployeeController::class, 'getAssignedAddresses']);
});

Route::group(['prefix'=>'address'], function(){
    Route::get('/get-all', [AddressController::class, 'getAll']);
    Route::get('/get-one/{id}', [AddressController::class, 'getOne']);
    Route::post('/create', [AddressController::class, 'create']);
    Route::post('/edit/{id}', [AddressController::class, 'edit']);
    Route::get('/delete/{id}', [AddressController::class, 'delete']);
    Route::get('/assigned-employees/{id}', [AddressController::class, 'getAssignedEmployees']);
});

Route::group(['prefix'=>'role'], function(){
    Route::get('/get-all', [RoleController::class, 'getAll']);
    Route::get('/get-one/{id}', [RoleController::class, 'getOne']);
    Route::post('/create', [RoleController::class, 'create']);
    Route::post('/edit/{id}', [RoleController::class, 'edit']);
    Route::get('/delete/{id}', [RoleController::class, 'delete']);
    Route::get('/assigned-employees/{id}', [RoleController::class, 'getAssignedEmployees']);
});