<?php

use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\TestimonialController;

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
Route::get('/',[HomeController::class,'home'])->name('home');
Route::get('/shop',[HomeController::class,'shopPage'])->name('shop.page');
Route::get('/single-product/{product_slug}',[HomeController::class,'ProductDetail'])->name('productdetail.page');
Route::get('/shopping-cart', [CartController::class, 'cartPage'])->name('cart.page');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to.cart');
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
    Route::resource('product', ProductController::class)->middleware(['auth']);
});

/*Admin Auth routes */
