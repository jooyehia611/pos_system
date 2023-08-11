<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\Client\OrderController;
use App\Http\Controllers\dashboard\ClientController;
use App\Http\Controllers\dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\dashboard\ProductController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    return redirect()->route('dashboard.welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes(['register' => false]);




// dashboard

Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect' , 'localizationRedirect' , 'localeViewPath']], function()
{
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){

        Route::get('' , [WelcomeController::class , 'index'])->name('welcome');


        // users Route
        Route::resource('users' , UserController::class)->except('show');   // كده هينفذ كل الميثود ماعدا دي

        // category Route
        Route::resource('categories' , CategoryController::class)->except('show');   // كده هينفذ كل الميثود ماعدا دي

        // product Route
        Route::resource('products' , ProductController::class)->except('show');   // كده هينفذ كل الميثود ماعدا دي

        // client routes
        Route::resource('clients' , ClientController::class)->except('show');   // كده هينفذ كل الميثود ماعدا دي

        // ordersClient Routes
        Route::resource('clients.orders' , OrderController::class)->except('show');   // كده هينفذ كل الميثود ماعدا دي

        // orders Routes
        Route::resource('orders' , DashboardOrderController::class);   // كده هينفذ كل الميثود ماعدا دي

        Route::get('/orders/{order}/products' ,  [DashboardOrderController::class , "products"])->name('orders.products');

        
    });
    
});




