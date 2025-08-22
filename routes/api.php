<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\UserController;

// public
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// protected
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Users
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);

    // Projects
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{project}', [ProjectController::class, 'show']);

    // Only admins can create/update/delete projects
    Route::middleware('admin.only')->group(function () {
        Route::post('projects', [ProjectController::class, 'store']);
        Route::put('projects/{project}', [ProjectController::class, 'update']);
        Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
    });

    // Tasks (create/update allowed for admin and member; delete only admin)
    Route::get('tasks', [TaskController::class, 'index']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::post('tasks', [TaskController::class, 'store']); // both roles
    // update only owner or admin
    Route::put('tasks/{task}', [TaskController::class, 'update'])->middleware('owner.or.admin');
    // delete only admin
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->middleware('admin.only');

    // assign task (only admin allowed or owner? here allow admin only, or you can modify)
    Route::post('tasks/{task}/assign', [TaskAssignmentController::class, 'assign'])->middleware('admin.only');
});
