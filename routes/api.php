<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::apiResource('employees', \App\Http\Controllers\Api\V1\EmployeeController::class);
    Route::apiResource('tickets', \App\Http\Controllers\Api\V1\TicketController::class);

});
