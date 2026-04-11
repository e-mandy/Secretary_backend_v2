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
Route::post('/refresh', [SecretaryController::class, 'refresh']);

// ---- Professor Module Routes ---- //
Route::get("/secretary/professors", [ProfessorController::class, 'index']);
Route::post("/secretary/professor/create", [ProfessorController::class, 'create']);
Route::put("/secretary/professor/{professorId}", [ProfessorController::class, 'update']);
Route::delete("/secretary/professor/{professorId}", [ProfessorController::class, "delete"]);