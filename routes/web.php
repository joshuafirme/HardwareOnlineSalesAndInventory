<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Admin\UserController;
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
use App\Http\Controllers\Admin\SupplierDeliveryController;
use App\Http\Controllers\Admin\InventoryReportController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\PurchaseOrderReportController;
use App\Http\Controllers\Admin\SupplierDeliveryReportController;
use App\Http\Controllers\Admin\ProductReturnController;
use App\Http\Controllers\Admin\ProductReturnReportController;
use App\Http\Controllers\Admin\ReorderListController;
use App\Http\Controllers\Admin\VerifyCustomerController;
use App\Http\Controllers\Admin\CustomerOrderController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PayMongoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAddressController;
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

Route::get('/home/category/{category_id}', [HomePageController::class, 'readProductByCategory']);

Route::get('/login', [UserAuthController::class, 'customer_index']);
Route::get('/signup', [UserAuthController::class, 'signup_view']);
Route::post('/create-account', [UserAuthController::class, 'createAccount'])->name('createAccount');
Route::post('/do-login', [UserAuthController::class, 'login'])->name('login');
/**
 * Admin
 */
Route::get('/admin', [UserAuthController::class, 'index']);
//Route::post('/admin/login', [UserAuthController::class, 'login'])->name('login');
Route::get('/admin/logout', [UserAuthController::class, 'logout']);


Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/read-items', [CartController::class, 'readCart']);
Route::get('/cart-count', [CartController::class, 'cartCount']);
Route::post('/add-to-cart', [CartController::class, 'addToCart']);

Route::middleware('auth')->group(function () {
    Route::resource('/account', AccountController::class);
    Route::get('/edit-account', [AccountController::class, 'editAccount']);
    Route::resource('/address', UserAddressController::class);
    Route::get('/cart-total', [CartController::class, 'cartTotal']);
    Route::post('/cart/remove-item/{id}', [CartController::class, 'removeItem']);
    Route::post('/cart/change-qty', [CartController::class, 'changeQuantity']);
    Route::resource('/checkout', CheckoutController::class);
    Route::post('/place-order', [CheckoutController::class,'placeOrder'])->name('placeOrder');
    Route::get('/create-source', [CheckoutController::class, 'createSource'])->name('createSource');
    Route::get('/create-payment', [CheckoutController::class, 'createPayment'])->name('createPayment');
    Route::get('/create-payment-method', [CheckoutController::class,'createPaymayaPaymentMethod'])->name('createPaymayaPaymentMethod');
    Route::get('/order-info/{source_id}/{payment_method}', [CheckoutController::class, 'orderInfo']);

    Route::get('/my-orders', [OrderController::class, 'index']);

    Route::get('/get-brgy/{municipality}', [UserAddressController::class, 'getBrgyByMunicipality']);

    Route::middleware('access_level:1:2:3:4')->group(function () {
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
      Route::get('preview-request-order', [PurchaseOrderController::class, 'previewRequestPurchaseOrder']);
      Route::get('download-request-order', [PurchaseOrderController::class, 'downloadRequestPurchaseOrder']);
      Route::get('purchased-order', [PurchaseOrderController::class, 'readPurchasedOrder']);
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
      Route::get('/pricing', [PricingController::class, 'index']);
      Route::post('/pricing/update', [PricingController::class, 'updatePricing']);
      Route::resource('supplier-delivery', SupplierDeliveryController::class);
      Route::post('/create-delivery', [SupplierDeliveryController::class, 'createDelivery']);
      Route::get('/read-supplier-delivery', [SupplierDeliveryController::class, 'readSupplierDelivery']);
      
      Route::resource('reports/sales', SalesController::class);
      Route::get('read-sales', [SalesController::class, 'readSales']);
      Route::get('compute-total-sales', [SalesController::class, 'computeTotalSales']);
      Route::get('reports/preview-sales/{date_from}/{date_to}/{order_from}/{payment_method}', [SalesController::class, 'previewSalesReport']);
      Route::get('reports/download-sales/{date_from}/{date_to}/{order_from}/{payment_method}', [SalesController::class, 'downloadSalesReport']);
      Route::get('reports/inventory', [InventoryReportController::class, 'index']);
      Route::get('reports/inventory/{category_id}', [InventoryReportController::class, 'readProductByCategory']);
      Route::get('/reports/inventory/preview/{category_id}', [InventoryReportController::class, 'previewReport']);
      Route::get('/reports/inventory/download/{category_id}', [InventoryReportController::class, 'downloadReport']);
  
      Route::get('/reports/purchased-order', [PurchaseOrderReportController::class, 'index']);
      Route::get('/purchased-order/preview/{supplier_id}/{date_from}/{date_to}', [PurchaseOrderReportController::class, 'previewReport']);
      Route::get('/purchased-order/download/{supplier_id}/{date_from}/{date_to}', [PurchaseOrderReportController::class, 'downloadReport']);
  
      Route::get('/reports/supplier-delivery', [SupplierDeliveryReportController::class, 'index']);
      Route::get('/supplier-delivery/preview/{supplier_id}/{date_from}/{date_to}', [SupplierDeliveryReportController::class, 'previewReport']);
      Route::get('/supplier-delivery/download/{supplier_id}/{date_from}/{date_to}', [SupplierDeliveryReportController::class, 'downloadReport']);
  
      Route::resource('product-return', ProductReturnController::class);
      Route::get('/product-return-read-sales', [ProductReturnController::class, 'readSales']);
      Route::post('/return', [ProductReturnController::class, 'return']);
      Route::get('/reports/product-return', [ProductReturnReportController::class, 'index']);
      Route::get('/product-return/preview/{date_from}/{date_to}', [ProductReturnReportController::class, 'previewReport']);
      Route::get('/product-return/download/{date_from}/{date_to}', [ProductReturnReportController::class, 'downloadReport']);
  
      Route::get('/reports/reorder', [ReorderListController::class, 'index']);
      Route::get('/reorder/preview/{supplier_id}', [ReorderListController::class, 'previewReport']);
      Route::get('/reorder/download/{supplier_id}', [ReorderListController::class, 'downloadReport']);
  
      Route::get('/verify-customer', [VerifyCustomerController::class, 'index']);
      Route::get('/verified-customer', [VerifyCustomerController::class, 'readAllVerifiedCustomer']);
      Route::post('/do-verify-customer/{user_id}', [VerifyCustomerController::class, 'verifyCustomer']);

      Route::get('/customer-orders', [CustomerOrderController::class, 'index']);
      Route::get('/read-pending-orders', [CustomerOrderController::class, 'readPendingOrders']);
      Route::get('/read-one-order/{order_no}', [CustomerOrderController::class, 'readOneOrder']);
      Route::post('/prepare-order/{order_no}', [CustomerOrderController::class, 'prepareOrder']);
      Route::get('/get-shipping-fee/{order_no}', [CustomerOrderController::class, 'getShippingFee']);
      Route::get('/read-shipping-address/{user_id}', [CustomerOrderController::class, 'readShippingAddress']);
    });
    
});