<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\frontend\HomeController;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;

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

// Route::get('/dashboard', function () {
//     return view('backend.pages.dashboard');
// });
// Route::get('/', function () {
//     return view('frontend.pages.home');
// });
Route::get('/',[HomeController::class,'home']);
/*Admin Auth routes */

Route::prefix('admin/')->group(function(){
    Route::get('login',[LoginController::class,'loginPage'])->name('admin.loginPage');
    Route::post('login',[LoginController::class,'login'])->name('admin.login');
    Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');

    Route::middleware(['auth'])->group(function(){
        Route::get('dashboard', function () {
            return view('backend.pages.dashboard');
        })->name('admin.dashboard');
    });

    // Category
    Route::resource('category', CategoryController::class)->middleware(['auth']);
    Route::resource('testimonial', TestimonialController::class)->middleware(['auth']);
});

/*Admin Auth routes */
