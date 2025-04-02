<?php

use App\Http\Controllers\Api\ChecklistSubmissionController;
use App\Http\Controllers\Api\DirectionController;
use App\Http\Controllers\Api\ErrorController;
use App\Http\Controllers\Api\ManagerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChecklistController;

//Route::post('/checklists', [ChecklistController::class, 'store']);
//Route::get('/checklists/', [ChecklistController::class, 'showAll']);
//Route::get('/checklists/{id}', [ChecklistController::class, 'show']);
//
//Route::post('/evaluations', [EvaluationController::class, 'store']);
//Route::get('/managers/{manager_name}/evaluations', [EvaluationController::class, 'indexByManager']);
//
//Route::post('/products', [ProductController::class, 'store']);
//Route::get('/products/{product_id}/checklists', [ChecklistController::class, 'indexByProduct']);
//Route::get('/products', [ProductController::class, 'index']);

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
Route::get('/evaluations/{managerName}', [ChecklistSubmissionController::class, 'indexByManager']);

