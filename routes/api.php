<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\UserManagementController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Authentication routes
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
// Routes for managing roles
Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    //view all users with role_id = 2
Route::get('/users', [UserManagementController::class, 'view_users']);
//create a new user
Route::post('/add/user', [UserManagementController::class, 'create_user']);
//edit user
Route::get('/user/{id}/edit', [UserManagementController::class, 'edit_user']);
//update existing user
Route::put('/update/user/{id}', [UserManagementController::class, 'update']);
//delete user
Route::delete('/user/{id}', [UserManagementController::class, 'delete_user']);
});
