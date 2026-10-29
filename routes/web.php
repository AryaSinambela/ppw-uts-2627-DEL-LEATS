<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoanController;

Route::get('/', function () { return view('welcome'); });

// RESTful Routing
Route::get('/equipments', [EquipmentController::class, 'index']);
Route::get('/equipments/create', [EquipmentController::class, 'create']);
Route::post('/equipments', [EquipmentController::class, 'store']);
Route::get('/equipments/{id}', [EquipmentController::class, 'show']);

Route::get('/loans/create', [LoanController::class, 'create']);
Route::post('/loans', [LoanController::class, 'store']);