<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\StockAdjustmentReportController;
use App\Http\Controllers\Admin\CashieringController;
use App\Http\Controllers\Admin\SalesController;

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

/**
 * Customer
 */
Route::get('/', [HomePageController::class, 'index']);
Route::get('/customer/product', [HomePageController::class, 'readAllProduct']);
Route::get('/customer/product/search', [HomePageController::class, 'searchProduct']);


/**
 * Admin
 */
Route::get('/admin', [LoginController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'login'])->name('login');
Route::get('/admin/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::resource('/admin/dashboard', UserController::class);
    Route::resource('users', UserController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('unit', UnitController::class);
    Route::post('user/archive/{id}', [UserController::class, 'archive']);
    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('delivery_area', DeliveryAreaController::class);
    Route::get('delivery_area/brgylist/{municipality}', [DeliveryAreaController::class,'getBrgyList']);
    Route::resource('stock-adjustment', StockAdjustmentController::class);
    Route::post('stock-adjustment/adjust/{id}', [StockAdjustmentController::class, 'adjust']);
    Route::resource('purchase-order', PurchaseOrderController::class);
    Route::get('display-reorders', [PurchaseOrderController::class, 'displayReorders']);
    Route::post('purchase-order/add-order', [PurchaseOrderController::class, 'addOrder']);
    Route::get('request-order', [PurchaseOrderController::class, 'readRequestOrderBySupplier']);
    Route::post('request-order/remove', [PurchaseOrderController::class, 'removeRequest']);
    Route::post('purchase-order', [PurchaseOrderController::class, 'purchaseOrder']);
    Route::get('purchased-order', [PurchaseOrderController::class, 'readPurchasedOrderBySupplier']);
    Route::get('supplier-markup', [SupplierController::class, 'getMarkupBySupplier']);
    Route::get('reports/stock-adjustment', [StockAdjustmentReportController::class, 'index']);
    Route::get('reports/stock-adjustment/pdf/{date_from}/{date_to}', [StockAdjustmentReportController::class, 'pdf']);
    Route::get('reports/stock-adjustment/download/{date_from}/{date_to}', [StockAdjustmentReportController::class, 'downloadPDF']);
    Route::get('cashiering', [CashieringController::class, 'index']);
    Route::post('record-sale', [CashieringController::class, 'recordSale']);
    Route::post('add-to-tray', [CashieringController::class, 'addToTray']);
    Route::get('read-tray', [CashieringController::class, 'readTray']);
    Route::get('cashiering/read-one-qty/{product_code}', [CashieringController::class, 'readOneQty']);
    Route::post('void/{id}', [CashieringController::class, 'void']);
    Route::get('preview-invoice', [CashieringController::class, 'previewInvoice']);
    Route::resource('reports/sales', SalesController::class);
    Route::get('read-sales', [SalesController::class, 'readSales']);

  //  Route::middleware('access_level:2')->group(function () {
  //      Route::resource('users', UserController::class);
  //  });
    
});