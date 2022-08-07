<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampgroundController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Campground;
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
Route::get('/campgrounds/{campground}',[CampgroundController::class, 'showCampgroundDetail']);
Route::delete('/campgrounds/{campground}',[CampgroundController::class,'deleteCampgrounds']);
Route::get('/campgrounds/{campground}/edit',[CampgroundController::class,'showEditForm']);
Route::put('/campgrounds/{campground}', [CampgroundController::class,'processEditCampground']);

require __DIR__.'/auth.php';
