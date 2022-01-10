<?php

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

/**
 * Customer
 */
Route::get('/', 'HomePageController@index');
Route::get('/customer/product', 'HomePageController@readAllProduct');
Route::get('/customer/product/search', 'HomePageController@searchProduct');

Route::get('/home/category/{category_id}', 'HomePageController@readProductByCategory');

Route::get('/login', 'UserAuthController@customer_index');
Route::get('/signup', 'UserAuthController@signup_view');
Route::post('/create-account', 'UserAuthController@createAccount')->name('createAccount');
Route::post('/do-login', 'UserAuthController@login')->name('login');
/**
 * Admin
 */
Route::get('/admin', 'UserAuthController@index');
//Route::post('/admin/login', 'UserAuthController@login'])->name('login');
Route::get('/admin/logout', 'UserAuthController@logout');


Route::get('/cart', 'CartController@index');
Route::get('/cart/read-items', 'CartController@readCart');
Route::get('/cart-count', 'CartController@cartCount');
Route::post('/add-to-cart', 'CartController@addToCart');

/**
 * Pages
 */
Route::get('/terms-and-condition', function(){
  return view('pages.terms-and-condition');
});

Route::middleware('auth')->group(function () {
    Route::resource('/account', 'AccountController');
    Route::get('/edit-account', 'AccountController@editAccount');
    Route::resource('/address', 'UserAddressController');
    Route::get('/cart-total', 'CartController@cartTotal');
    Route::post('/cart/remove-item/{id}', 'CartController@removeItem');
    Route::post('/cart/change-qty', 'CartController@changeQuantity');
    Route::resource('/checkout', 'CheckoutController');
    Route::post('/place-order', 'CheckoutController@placeOrder')->name('placeOrder');
    Route::get('/create-source', 'CheckoutController@createSource')->name('createSource');
    Route::get('/create-payment', 'CheckoutController@createPayment')->name('createPayment');
    Route::get('/create-payment-method', 'CheckoutController@createPaymayaPaymentMethod')->name('createPaymayaPaymentMethod');
    Route::get('/order-info/{source_id}/{payment_method}', 'CheckoutController@orderInfo');

    Route::get('/my-orders', 'OrderController@index');
    Route::post('/cancel-order/{order_no}', 'OrderController@cancelOrder');
    Route::get('/get-brgy/{municipality}', 'UserAddressController@getBrgyByMunicipality');
    Route::post('/send-feedback', 'OrderController@sendFeedback');
    Route::get('/read-feedback', 'OrderController@readOneFeedback');
    
    Route::middleware('access_level:1:2:3:4')->group(function () {
      Route::get('/dashboard', 'Admin\DashboardController@index');
      Route::resource('users', 'Admin\UserController');
      Route::resource('supplier', 'Admin\SupplierController');
      Route::resource('unit', 'Admin\UnitController');
      Route::post('user/archive/{id}', 'Admin\UserController@archive');
      Route::resource('product', 'Admin\ProductController');
      Route::get('/product-search', 'Admin\ProductController@productSearch');
      Route::post('/product/archive/{id}', 'Admin\ProductController@archive');
      Route::resource('category', 'Admin\CategoryController');
      Route::resource('delivery_area', 'Admin\DeliveryAreaController');
      Route::get('delivery_area/brgylist/{municipality}', 'Admin\DeliveryAreaController@getBrgyList');
      Route::resource('stock-adjustment', 'Admin\StockAdjustmentController');
      Route::post('stock-adjustment/adjust/{id}', 'Admin\StockAdjustmentController@adjust');
      Route::resource('purchase-order', 'Admin\PurchaseOrderController');
      Route::get('display-reorders', 'Admin\PurchaseOrderController@displayReorders');
      Route::post('purchase-order/add-order', 'Admin\PurchaseOrderController@addOrder');
      Route::get('request-order', 'Admin\PurchaseOrderController@readRequestOrderBySupplier');
      Route::post('request-order/remove', 'Admin\PurchaseOrderController@removeRequest');
      Route::post('purchase-order', 'Admin\PurchaseOrderController@purchaseOrder');
      Route::get('preview-request-order', 'Admin\PurchaseOrderController@previewRequestPurchaseOrder');
      Route::get('download-request-order', 'Admin\PurchaseOrderController@downloadRequestPurchaseOrder');
      Route::get('purchased-order', 'Admin\PurchaseOrderController@readPurchasedOrder');
      Route::get('reports/stock-adjustment', 'Admin\StockAdjustmentReportController@index');
      Route::get('reports/stock-adjustment/pdf/{date_from}/{date_to}', 'Admin\StockAdjustmentReportController@pdf');
      Route::get('reports/stock-adjustment/download/{date_from}/{date_to}', 'Admin\StockAdjustmentReportController@downloadPDF');
      Route::get('cashiering', 'Admin\CashieringController@index');
      Route::post('/record-sale', 'Admin\CashieringController@recordSale');
      Route::post('add-to-tray', 'Admin\CashieringController@addToTray');
      Route::get('read-tray', 'Admin\CashieringController@readTray');
      Route::get('cashiering/read-one-qty/{product_code}', 'Admin\CashieringController@readOneQty');
      Route::post('void/{id}', 'Admin\CashieringController@void');
      Route::get('preview-invoice/{wholesale_discount_amount}/{senior_pwd_discount_amount}', 'Admin\CashieringController@previewInvoice');
      Route::get('/pricing', 'Admin\PricingController@index');
      Route::post('/pricing/update', 'Admin\PricingController@updatePricing');
      Route::resource('supplier-delivery', 'Admin\SupplierDeliveryController');
      Route::post('/create-delivery', 'Admin\SupplierDeliveryController@createDelivery');
      Route::get('/read-supplier-delivery', 'Admin\SupplierDeliveryController@readSupplierDelivery');
      
      Route::resource('reports/sales', 'Admin\SalesController');
      Route::get('read-sales', 'Admin\SalesController@readSales');
      Route::get('/compute-total-sales', 'Admin\SalesController@computeTotalSales');
      Route::get('reports/preview-sales/{date_from}/{date_to}/{order_from}/{payment_method}', 'Admin\SalesController@previewSalesReport');
      Route::get('reports/download-sales/{date_from}/{date_to}/{order_from}/{payment_method}', 'Admin\SalesController@downloadSalesReport');
      Route::get('reports/inventory', 'Admin\InventoryReportController@index');
      Route::get('reports/inventory/{category_id}', 'Admin\InventoryReportController@readProductByCategory');
      Route::get('/reports/inventory/preview/{category_id}', 'Admin\InventoryReportController@previewReport');
      Route::get('/reports/inventory/download/{category_id}', 'Admin\InventoryReportController@downloadReport');
  
      Route::get('/reports/purchased-order', 'Admin\PurchaseOrderReportController@index');
      Route::get('/purchased-order/preview/{supplier_id}/{date_from}/{date_to}', 'Admin\PurchaseOrderReportController@previewReport');
      Route::get('/purchased-order/download/{supplier_id}/{date_from}/{date_to}', 'Admin\PurchaseOrderReportController@downloadReport');
  
      Route::get('/reports/supplier-delivery', 'Admin\SupplierDeliveryReportController@index');
      Route::get('/supplier-delivery/preview/{supplier_id}/{date_from}/{date_to}', 'Admin\SupplierDeliveryReportController@previewReport');
      Route::get('/supplier-delivery/download/{supplier_id}/{date_from}/{date_to}', 'Admin\SupplierDeliveryReportController@downloadReport');
  
      Route::resource('product-return', 'Admin\ProductReturnController');
      Route::get('/product-return-read-sales', 'Admin\ProductReturnController@readSales');
      Route::post('/return', 'Admin\ProductReturnController@return');
      Route::get('/reports/product-return', 'Admin\ProductReturnReportController@index');
      Route::get('/product-return/preview/{date_from}/{date_to}', 'Admin\ProductReturnReportController@previewReport');
      Route::get('/product-return/download/{date_from}/{date_to}', 'Admin\ProductReturnReportController@downloadReport');
  
      Route::get('/reports/reorder', 'Admin\ReorderListController@index');
      Route::get('/reorder/preview/{supplier_id}', 'Admin\ReorderListController@previewReport');
      Route::get('/reorder/download/{supplier_id}', 'Admin\ReorderListController@downloadReport');

      Route::get('/reports/fast-and-slow', 'Admin\FastAndSlowMovingController@index');
  
      Route::get('/verify-customer', 'Admin\VerifyCustomerController@index');
      Route::get('/verified-customer', 'Admin\VerifyCustomerController@readAllVerifiedCustomer');
      Route::post('/do-verify-customer/{user_id}', 'Admin\VerifyCustomerController@verifyCustomer');

      Route::get('/customer-orders', 'Admin\CustomerOrderController@index');
      Route::get('/read-orders', 'Admin\CustomerOrderController@readOrders');
      Route::get('/read-one-order/{order_no}', 'Admin\CustomerOrderController@readOneOrder');
      Route::post('/order-change-status/{order_no}', 'Admin\CustomerOrderController@orderChangeStatus');
      Route::get('/get-shipping-fee/{order_no}', 'Admin\CustomerOrderController@getShippingFee');
      Route::get('/read-shipping-address/{user_id}', 'Admin\CustomerOrderController@readShippingAddress');

      Route::get('/audit-trail', 'Admin\AuditTrailController@index');
      Route::get('/archive', 'Admin\ArchiveController@index');
      Route::get('/archive/products', 'Admin\ArchiveController@readArchiveProduct');
      Route::get('/archive/users', 'Admin\ArchiveController@readArchiveUsers');
      Route::post('/archive/restore/{id}', 'Admin\ArchiveController@restore');
      Route::get('/archive/sales', 'Admin\ArchiveController@readArchiveSales');

      Route::get('/feedback', 'Admin\FeedbackController@index');

      Route::resource('discount', 'Admin\DiscountController');
      Route::get('/backup-and-restore', 'Admin\BackupAndRestoreController@index');
      Route::post('/backup-and-restore/backup', 'Admin\BackupAndRestoreController@backup')->name('backup');
      Route::post('/backup-and-restore/restore', 'Admin\BackupAndRestoreController@restore')->name('restore');

      Route::get('/notification', 'Admin\NotificationController@index');

      Route::post('/reports/archive/{id}', 'Admin\SalesController@archive');
    });
    Route::get('/read-discount', 'Admin\DiscountController@readDiscount');

    
});


Route::get('/contact-us', 'PagesController@contactUs');
Route::get('/about-us', 'PagesController@aboutUs');
Route::get('/privacy-policy', 'PagesController@privacyPolicy');
Route::get('/we-deliver', 'PagesController@weDeliver');
Route::get('/return-and-cancellation-policy', 'PagesController@returnAndCancellationPolicy');