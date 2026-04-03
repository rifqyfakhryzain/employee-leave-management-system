<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/leave', [LeaveRequestController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/my-leaves', [LeaveRequestController::class, 'myLeaves']);

Route::middleware('auth:sanctum')->get('/leaves', [LeaveRequestController::class, 'index']);
Route::middleware('auth:sanctum')->post('/leaves/{id}/approve', [LeaveRequestController::class, 'approve']);
Route::middleware('auth:sanctum')->post('/leaves/{id}/reject', [LeaveRequestController::class, 'reject']);