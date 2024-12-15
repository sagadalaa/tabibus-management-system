<?php
/**
 * Web Routes for Clinic Management System
 * Author: Your Name
 * Description: Defines routes for the web application.
 */

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PatientController;
use App\Controllers\AppointmentController;
use App\Controllers\ServiceController;
use App\Controllers\ReportController;
use App\Controllers\SystemController;
use App\Controllers\MessagingController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RoleMiddleware;

// Authentication Routes
$router->get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest');
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest');
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Dashboard Route
$router->get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Patient Routes
$router->get('/patients', [PatientController::class, 'index'])->middleware('auth');
$router->get('/patients/add', [PatientController::class, 'create'])->middleware('auth');
$router->post('/patients', [PatientController::class, 'store'])->middleware('auth');
$router->get('/patients/{id}/edit', [PatientController::class, 'edit'])->middleware('auth');
$router->post('/patients/{id}/update', [PatientController::class, 'update'])->middleware('auth');
$router->post('/patients/{id}/delete', [PatientController::class, 'destroy'])->middleware('auth');

// Appointment Routes
$router->get('/appointments', [AppointmentController::class, 'index'])->middleware('auth');
$router->get('/appointments/add', [AppointmentController::class, 'create'])->middleware('auth');
$router->post('/appointments', [AppointmentController::class, 'store'])->middleware('auth');
$router->get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->middleware('auth');
$router->post('/appointments/{id}/update', [AppointmentController::class, 'update'])->middleware('auth');
$router->post('/appointments/{id}/delete', [AppointmentController::class, 'destroy'])->middleware('auth');

// Services Routes
$router->get('/services', [ServiceController::class, 'index'])->middleware('auth');
$router->get('/services/add', [ServiceController::class, 'create'])->middleware('auth');
$router->post('/services', [ServiceController::class, 'store'])->middleware('auth');
$router->get('/services/{id}/edit', [ServiceController::class, 'edit'])->middleware('auth');
$router->post('/services/{id}/update', [ServiceController::class, 'update'])->middleware('auth');
$router->post('/services/{id}/delete', [ServiceController::class, 'destroy'])->middleware('auth');

// Reports Routes
$router->get('/reports', [ReportController::class, 'index'])->middleware('auth');
$router->get('/reports/generate', [ReportController::class, 'generate'])->middleware('auth');
$router->get('/reports/print', [ReportController::class, 'print'])->middleware('auth');

// System Routes
$router->get('/system', [SystemController::class, 'index'])->middleware('auth');
$router->get('/system/clinic-info/edit', [SystemController::class, 'editClinicInfo'])->middleware('auth');
$router->post('/system/clinic-info/update', [SystemController::class, 'updateClinicInfo'])->middleware('auth');
$router->get('/system/receptionists', [SystemController::class, 'manageReceptionists'])->middleware('auth');
$router->post('/system/receptionists/add', [SystemController::class, 'addReceptionist'])->middleware('auth');
$router->post('/system/receptionists/{id}/delete', [SystemController::class, 'deleteReceptionist'])->middleware('auth');
$router->get('/system/subscription', [SystemController::class, 'subscriptionDetails'])->middleware('auth');
$router->post('/system/subscription/renew', [SystemController::class, 'renewSubscription'])->middleware('auth');
$router->post('/system/backup/create', [SystemController::class, 'createBackup'])->middleware('auth');
$router->post('/system/backup/restore', [SystemController::class, 'restoreBackup'])->middleware('auth');

// Messaging Routes
$router->get('/messages', [MessagingController::class, 'index'])->middleware('auth');
$router->post('/messages/send', [MessagingController::class, 'sendMessage'])->middleware('auth');

// Unauthorized Access Route
$router->get('/unauthorized', function () {
    echo 'You are not authorized to access this page.';
});
