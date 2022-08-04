<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampgroundController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'home']);
Route::get('/campgrounds',[CampgroundController::class,'home']);
Route::get('/campgrounds/add',[CampgroundController::class,'showAddCampground']);
Route::post('/campgrounds/add',[CampgroundController::class,'processAddCampground']);
Route::get('/campgrounds/{id}',[CampgroundController::class, 'showCampgroundDetail']);
Route::delete('/campgrounds/{id}',[CampgroundController::class,'deleteCampgrounds']);
Route::get('/campgrounds/{id}/edit',[CampgroundController::class,'showEditForm']);
Route::put('/campgrounds/{id}', [CampgroundController::class,'processEditCampground']);
