<?php

use App\Http\Controllers\Api\ChecklistController;
use Illuminate\Support\Facades\Route;

Route::get('/directions', [DirectionController::class, 'index']);
Route::post('/directions', [DirectionController::class, 'store']);

Route::get('/managers', [ManagerController::class, 'index']);
Route::post('/managers', [ManagerController::class, 'store']);

Route::get('/errors', [ErrorController::class, 'index']);
Route::post('/errors', [ErrorController::class, 'store']);

Route::get('/products/{direction}/checklists', [ChecklistController::class, 'index']);
Route::post('/checklists', [ChecklistController::class, 'store']);
Route::delete('/checklists/{id}', [ChecklistController::class, 'destroy']);

Route::post('/evaluations', [ChecklistSubmissionController::class, 'store']);
