<?php

use App\Http\Controllers\ApiController\Auth\AdminController;
use App\Http\Controllers\ApiController\Auth\SecretaryController;
use App\Http\Controllers\ApiController\Professor\ProfessorController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// ---- Authentication Routes ---- //
Route::post('/admin/login', [AdminController::class, 'login']);


Route::post('/secretary/login', [SecretaryController::class, 'login']);
Route::post('/secretary/register', [SecretaryController::class, 'register']);
Route::get('/secretary/email-verify/{id}/{hash}', [SecretaryController::class, 'verify'])->name('verification.verify')->middleware('signed');


// ---- Professor Module Routes ---- //
Route::post("/secretary/professor/store", [ProfessorController::class, 'store']);