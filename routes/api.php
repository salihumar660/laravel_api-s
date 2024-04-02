<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserManagementController;

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
Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::middleware('web')->post('logout', [AuthenticationController::class, 'logout_user']);

// Routes for managing roles
// Route::middleware('auth:sanctum')->group(function () {
//     // Get the authenticated user
//     Route::get('user', function (Request $request) {
//         return $request->user();
//     });

//     // View all users with role_id = 2
//     Route::get('users', [UserManagementController::class, 'view_users']);

//     // Create a new user
//     Route::post('add/user', [UserManagementController::class, 'create_user']);

//     // Edit user (retrieve user data for editing)
//     Route::get('edit/user/{id}', [UserManagementController::class, 'edit_user']);

//     // Update existing user
//     Route::put('update/user/{id}', [UserManagementController::class, 'update']);

//     // Delete user
//     Route::delete('delete/user/{id}', [UserManagementController::class, 'delete_user']);
// });

Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // View all users
    // Route::get('users', [UserManagementController::class, 'view_users']);

    Route::get('users', function () {
        return response()->json(['message' => 'This is a test route.'], 200);
    });
    

    // Other user management routes...

    // Example of creating a new user
    Route::post('users', [UserManagementController::class, 'create_user']);
});
