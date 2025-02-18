<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/demo', function(){
    return view('demo');
});


Route::post('/users/create', [UserController::class, 'create'])->name('createUser');
Route::put('/users/update', [UserController::class, 'create'])->name('updateUser');