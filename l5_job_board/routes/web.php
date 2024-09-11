<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\UserController;
use App\Http\Controllers\JobController;

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

// this will re route to localhost:8000 to localhost:8000/jobs
Route::get('',fn()=>to_route('jobs.index'));

Route::resource('jobs',JobController::class)->only(['index','show']);