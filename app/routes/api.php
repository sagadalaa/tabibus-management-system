<?php
/**
 * API Routes for Clinic Management System
 * Author: Your Name
 * Description: Defines API routes for the application.
 */

use App\Controllers\Api\AuthController;
use App\Controllers\Api\PatientController;
use App\Controllers\Api\AppointmentController;
use App\Controllers\Api\ServiceController;
use App\Controllers\Api\ReportController;
use App\Controllers\Api\SystemController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;

// Base API response for unauthorized access
$router->group('/api', function ($router) {

    // Authentication Routes
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    $router->post('/register', [AuthController::class, 'register']);

    // Patient API Routes (Requires Authentication)
    $router->group('/patients', function ($router) {
        $router->get('', [PatientController::class, 'getAll'])->middleware('auth');
        $router->get('/{id}', [PatientController::class, 'get'])->middleware('auth');
        $router->post('', [PatientController::class, 'create'])->middleware('auth');
        $router->put('/{id}', [PatientController::class, 'update'])->middleware('auth');
        $router->delete('/{id}', [PatientController::class, 'delete'])->middleware('auth');
    });

    // Appointment API Routes (Requires Authentication)
    $router->group('/appointments', function ($router) {
        $router->get('', [AppointmentController::class, 'getAll'])->middleware('auth');
        $router->get('/{id}', [AppointmentController::class, 'get'])->middleware('auth');
        $router->post('', [AppointmentController::class, 'create'])->middleware('auth');
        $router->put('/{id}', [AppointmentController::class, 'update'])->middleware('auth');
        $router->delete('/{id}', [AppointmentController::class, 'delete'])->middleware('auth');
    });

    // Services API Routes (Requires Authentication)
    $router->group('/services', function ($router) {
        $router->get('', [ServiceController::class, 'getAll'])->middleware('auth');
        $router->get('/{id}', [ServiceController::class, 'get'])->middleware('auth');
        $router->post('', [ServiceController::class, 'create'])->middleware('auth');
        $router->put('/{id}', [ServiceController::class, 'update'])->middleware('auth');
        $router->delete('/{id}', [ServiceController::class, 'delete'])->middleware('auth');
    });

    // Report API Routes (Requires Authentication)
    $router->group('/reports', function ($router) {
        $router->get('', [ReportController::class, 'getSummary'])->middleware('auth');
        $router->post('/generate', [ReportController::class, 'generate'])->middleware('auth');
        $router->get('/print', [ReportController::class, 'print'])->middleware('auth');
    });

    // System API Routes (Requires Authentication and Admin Role)
    $router->group('/system', function ($router) {
        $router->get('/info', [SystemController::class, 'getInfo'])->middleware('auth');
        $router->post('/settings/update', [SystemController::class, 'updateSettings'])->middleware('auth', 'admin');
        $router->post('/backup', [SystemController::class, 'createBackup'])->middleware('auth', 'admin');
        $router->post('/restore', [SystemController::class, 'restoreBackup'])->middleware('auth', 'admin');
    });

    // Fallback for unauthorized API access
    $router->get('/unauthorized', function () {
        echo json_encode(['error' => 'Unauthorized access.']);
    });
});
