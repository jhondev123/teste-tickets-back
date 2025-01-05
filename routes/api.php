<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::apiResource('employees', \App\Http\Controllers\Api\V1\EmployeeController::class);
    Route::get('employee/search', [\App\Http\Controllers\Api\V1\EmployeeController::class, 'search'])
        ->name('employee.search');
    Route::apiResource('tickets', \App\Http\Controllers\Api\V1\TicketController::class);

    Route::prefix('/reports')->group(function () {
        Route::get(
            'tickets/by/employee/period',
            [\App\Http\Controllers\Api\V1\ReportController::class, 'searchTicketsByEmployeeAndPeriod'])
            ->name('reports.tickets.by.employee.period');

        Route::post(
            'tickets/generate',
            [\App\Http\Controllers\Api\V1\ReportController::class,
                'generateReportSearchTickets']
        )->name('reports.tickets.generate');
    });
});
