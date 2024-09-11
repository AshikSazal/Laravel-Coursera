<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('events',EventController::class);
// scoped(['attendee'=>'event']) means attendee always part of an event
// In every api route event is the parent part of attendee
// Route::apiResource('events.attendees', AttendeeController::class)->scoped(['attendee'=>'event']); 
// ->except('update') will remove the update route from route list
Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except('update'); // '['attendee'=>'event'] I don't need this cos laravel will automatically find out