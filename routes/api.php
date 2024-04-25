<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AudioManagementController;

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
Route::post('audio-upload-path', [AudioManagementController::class, 'create_audio']);
Route::post('user-create-path', [UserManagementController::class, 'create_user']);
Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::middleware('web')->post('logout', [AuthenticationController::class, 'logout_user']);

// Routes for managing roles
Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('user', function (Request $request) {
        return $request->user();
    });
});
    // View all users with role_id = 2
    Route::get('users', [UserManagementController::class, 'view_users']);

    // Create a new user
    Route::post('add/user', [UserManagementController::class, 'create_user']);

    // Edit user (retrieve user data for editing)
    Route::get('/user/{id}', [UserManagementController::class, 'edit_user']);

    // Update existing user
    Route::put('/user/{id}', [UserManagementController::class, 'update']);

    // Delete user
    Route::delete('/user/{id}', [UserManagementController::class, 'delete_user']);

    //USER MANAGEMENT API'S
    Route::get('users', [UserManagementController::class, 'view_users']);

    Route::post('add/user', [UserManagementController::class, 'create_user']);

    Route::get('/user/{id}', [UserManagementController::class, 'edit_user']);

    Route::put('/user/{id}', [UserManagementController::class, 'update']);

    Route::delete('user/{id}', [UserManagementController::class, 'delete_user']);

    //AUDIO MANAGEMENT API'S
    Route::get('all/audios', [AudioManagementController::class, 'view_audios']);

    // Route::post('add/audio', [AudioManagementController::class, 'create_audio']);
    
    Route::put('push-image', [AudioManagementController::class, 'create_audio']);

    //FOR LANDING PAGE AND ADMIN SIDE 
    Route::get('uploaded/audio', [AudioManagementController::class, 'audios']);
    Route::delete('audio/delete', [AudioManagementController::class, 'del_audio']);


Route::get('/clear-api-routes', function () {
    // Clear route cache
    Artisan::call('route:clear');
    Artisan::call   ('config:cache');
    
    // Re-cache routes, including only API routes
    Artisan::call('route:cache');

    return Artisan::call('route:list');
    // return "API routes cache cleared!";
});