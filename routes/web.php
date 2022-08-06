<?php

use App\Http\Controllers\CampgroundController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
Route::get('/campgrounds/{id}',[CampgroundController::class, 'showCampgroundDetail'])->where('id','^[0-9a-fA-F]{24}$');
Route::delete('/campgrounds/{id}',[CampgroundController::class,'deleteCampgrounds'])->where('id','^[0-9a-fA-F]{24}$');
Route::get('/campgrounds/{id}/edit',[CampgroundController::class,'showEditForm'])->where('id','^[0-9a-fA-F]{24}$');
Route::put('/campgrounds/{id}', [CampgroundController::class,'processEditCampground'])->where('id','^[0-9a-fA-F]{24}$');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
