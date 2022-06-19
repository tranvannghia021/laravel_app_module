<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProductsController;
use App\Http\Controllers\admin\CategoryController;


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

//admin(sẽ áp dụng check role)
Route::prefix('/admin')->group(function (){
    // products
    Route::prefix('/products')->group(function (){
        Route::get('/list',[ProductsController::class,'index'])->name('products.list');
        Route::post('/list',[ProductsController::class,'index']);
        Route::get('/show/{id}',[ProductsController::class,'show'])->name('products.show');
        Route::get('/add',[ProductsController::class,'create'])->name('products.add');
        Route::post('/add',[ProductsController::class,'store']);
        Route::get('/edit/{id}',[ProductsController::class,'edit'])->name('products.edit');
        Route::post('/edit/{id}',[ProductsController::class,'update']);
        //áp dụng ajax vào để delete tránh mã độc
        //Route::delete('/destroy',[ProductsController::class,'destroy']);
        // tạm thời fix cứng
        Route::get('/destroy/{id}',[ProductsController::class,'destroy'])->name('products.delete');
    });

     // category
     Route::prefix('/category')->group(function (){
        //add
        Route::get('/list',[CategoryController::class,'index'])->name('categorys.list');
        Route::post('/list',[CategoryController::class,'store']);
        
        //update
        Route::get('/list/{id}',[CategoryController::class,'edit'])->name('categorys.edit');
        Route::post('/list/{id}',[CategoryController::class,'update']);
        // áp dụng ajax vào để delete tránh mã độc
       // Route::delete('/destroy',[CategoryController::class,'destroy']);
        // tạm thời fix cứng
        Route::get('/destroy/{id}',[CategoryController::class,'destroy'])->name('categorys.delete');
    });
    Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
    
});
//client
//fix cứng đê lọt vào admin
Route::get('/',[DashboardController::class,'index']);