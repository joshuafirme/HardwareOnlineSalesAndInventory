<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\PurchaseOrderController;

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


Route::get('/admin', [LoginController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'login'])->name('login');
Route::get('/admin/logout', [LoginController::class, 'logout']);
Route::resource('/admin/dashboard', UserController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('supplier', SupplierController::class)->middleware(['auth']);
Route::resource('unit', UnitController::class)->middleware(['auth']);
Route::post('user/archive/{id}', [UserController::class, 'archive'])->middleware(['auth']);
Route::resource('product', ProductController::class)->middleware(['auth']);
Route::resource('category', CategoryController::class)->middleware(['auth']);
Route::resource('delivery_area', DeliveryAreaController::class)->middleware(['auth']);
Route::get('delivery_area/brgylist/{municipality}', [DeliveryAreaController::class,'getBrgyList']);
Route::resource('stock-adjustment', StockAdjustmentController::class)->middleware(['auth']);
Route::post('stock-adjustment/adjust/{id}', [StockAdjustmentController::class, 'adjust'])->middleware(['auth']);
Route::resource('purchase-order', PurchaseOrderController::class)->middleware(['auth']);
Route::get('display-reorders', [PurchaseOrderController::class, 'displayReorders'])->middleware(['auth']);
Route::post('purchase-order/add-order', [PurchaseOrderController::class, 'addOrder'])->middleware(['auth']);
