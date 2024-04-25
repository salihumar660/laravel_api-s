<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AudioManagementController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

// Route::post('/post', [AudioManagementController::class, 'create_audio']);

Route::get('/images/{filename}', [AudioManagementController::class, 'getImage']);

Route::get('/audio/{filename}', [AudioManagementController::class, 'getAudio']);

Route::get('/create-storage-link', function () {
    Artisan::call('storage:link');
    
    return "Storage link created!";
});

Route::get('/clear-route-cache', function () {
    Artisan::call('route:clear');
    
    return "Route cache cleared!";
});