<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('app/v1/')->group(function (){
    Route::prefix('product')->name('product.')->group(function (){
        Route::get('', [ProductController::class, 'fetch'])->name('product.fetch');
        Route::get('/{id}', [ProductController::class, 'findById'])->name('product.find-by-id');
        Route::post('', [ProductController::class, 'createProduct'])->name('product.create-product');
        Route::put('/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update-product');
        Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete-product');
    });

    Route::prefix('category')->name('category.')->group(function (){
        Route::get('', [CategoryController::class, 'fetch'])->name('category.fetch');
        Route::get('/{id}', [CategoryController::class, 'findById'])->name('category.find-by-id');
        Route::post('', [CategoryController::class, 'createCategory'])->name('category.create-category');
        Route::put('/update/{id}', [CategoryController::class, 'updateCategory'])->name('category.update-category');
        Route::delete('/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete-category');
    });

    Route::prefix('status')->name('product.')->group(function (){
        Route::get('', [StatusController::class, 'fetch'])->name('status.fetch');
        Route::get('/{id}', [StatusController::class, 'findById'])->name('status.find-by-id');
        Route::post('', [StatusController::class, 'createStatus'])->name('status.create-status');
        Route::put('/update/{id}', [StatusController::class, 'updateStatus'])->name('status.update-status');
        Route::delete('/{id}', [StatusController::class, 'deleteStatus'])->name('status.delete-status');
    });

});
