<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api', 'cors', 'status']], function () {
    // Auth routes (guest)
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('loginAdmin', 'AuthController@loginAdmin');
        Route::post('registerAdmin', 'AuthController@registerAdmin');
        Route::post('register', 'AuthController@register');
        Route::post('register-unknowing', 'AuthController@registerUnknowing');
        Route::get('reset-password/{token}', 'AuthController@confirmResetToken')->where('token', '.*');
        Route::post('reset-password', 'AuthController@resetPassword');
        Route::post('send-reset-token', 'AuthController@sendResetToken');
    });

    // Auth routes
    Route::group(['namespace' => 'Auth', 'middleware' => ['jwt']], function () {
        Route::get('refresh-token', 'AuthController@refreshToken');
        Route::post('logout', 'AuthController@logout');
        Route::post('update-user', 'AuthController@updateUser');
    });

    // User routes
    Route::group([
        'prefix' => 'users',
        'namespace' => 'User'
    ], function () {
        Route::get('/', 'UserController@getUsers')
            ->middleware(['jwt', 'admin']);
        Route::get('/admins', 'UserController@getAdmins')
            ->middleware(['jwt']);
        Route::get('/orders', 'UserController@orders')->where('id', '\d+')->middleware(['jwt']);
        Route::post('/updateAdmin', 'UserController@updateAdmin')->middleware(['jwt', 'admin']);
        Route::post('/deleteAdmin', 'UserController@deleteAdmin')->middleware(['jwt', 'admin']);
        Route::post('/updatePassword', 'UserController@updatePassword')->middleware(['jwt', 'admin']);
        Route::get('/{id}', 'UserController@show')->where('id', '\d+')->middleware(['jwt', 'admin']);
        Route::get('/{id}/orders', 'UserController@ordersByID')->where('id', '\d+')->middleware(['jwt']);
        Route::put('/{id}', 'UserController@update')->where('id', '\d+')->middleware(['jwt', 'admin']);
        Route::delete('/{id}', 'UserController@destroy')->where('id', '\d+')->middleware(['jwt', 'admin']);
    });

    // Cash Request routes
    Route::group([
        'prefix' => 'cash-request',
        'namespace' => 'CashRequest',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::post('/', 'CashRequestController@store');
        Route::get('/', 'CashRequestController@index');
        Route::put('/{id}', 'CashRequestController@status')->where('id', '\d+');
        Route::post('/changeStatus', 'CashRequestController@changeStatus');
    });

    // Location routes
    Route::group([
        'prefix' => 'locations',
        'namespace' => 'Logistics'
    ], function () {
        Route::get('/', 'LocationController@index');
        Route::get('/zones', 'LocationController@getZones');
        Route::get('/all-zones', 'LocationController@getAllZones')->middleware(['jwt', 'admin']);
        Route::get('/{id}', 'LocationController@show');
        Route::get('/{id}/order', 'LocationController@orders')->middleware(['jwt', 'admin']);
        Route::post('/', 'LocationController@store')->middleware(['jwt', 'admin']);
        Route::post('/update', 'LocationController@update')->middleware(['jwt', 'admin']);
        Route::delete('/{id}', 'LocationController@destroy')->middleware(['jwt', 'admin']);
    });

    // Vendors routes
    Route::group([
        'prefix' => 'vendors',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::get('/', 'VendorController@getVendors')->middleware(['jwt', 'admin']);
        Route::get('/all', 'VendorController@getAllVendors')->middleware(['jwt', 'admin']);
        Route::post('/', 'VendorController@storeVendors')->middleware(['jwt', 'admin']);
    });

    // Delivery Windows routes
    Route::group([
        'prefix' => 'delivery-windows',
    ], function () {
        Route::post('/', 'DeliveryWindowController@store');
        Route::get('/all', 'DeliveryWindowController@all')->where('all', '.*');
        Route::get('/{date?}', 'DeliveryWindowController@index')->where('date', '.*');
        Route::post('/changeDeliveryWindowStatus', 'DeliveryWindowController@changeDeliveryWindowStatus');
        Route::post('/regularDeliveryDate', 'DeliveryWindowController@regularDeliveryDate');
    });

    // Companies
    Route::group([
        'prefix' => 'companies',
        'namespace' => 'Logistics'
    ], function () {
        Route::get('/', 'CompanyController@index');
        Route::get('/{id}', 'CompanyController@show');
        Route::get('/{id}/order', 'CompanyController@orders')->middleware(['jwt', 'admin']);
        Route::post('/', 'CompanyController@store')->middleware(['jwt', 'admin']);
        Route::post('/update', 'CompanyController@update')->middleware(['jwt', 'admin']);
        Route::delete('/{id}', 'CompanyController@destroy')->middleware(['jwt', 'admin']);
    });

    // Packages routes
    Route::group([
        'prefix' => 'packages',
        'namespace' => 'Packages'
    ], function () {
        Route::get('/', 'PackageController@getPackages');
        Route::get('/all', 'PackageController@getAllPackages');
        Route::get('/custom-pack', 'PackageController@getCustomPack');
        Route::get('/{id}', 'PackageController@show')->where('id', '\d+');
        Route::post('/', 'PackageController@store')->middleware(['jwt', 'admin']);
        Route::post('/uploadImage', 'PackageController@uploadImage');
        Route::post('/updateStatus', 'PackageController@updateStatus');
        Route::put('/{id}', 'PackageController@update')->where('id', '\d+')->middleware(['jwt', 'admin']);
        Route::delete('/{id}', 'PackageController@destroy')->where('id', '\d+')->middleware(['jwt', 'admin']);
    });

    // Order routes
    Route::group([
        'prefix' => 'orders',
        'namespace' => 'Order'
    ], function () {
        Route::post('/', 'OrderController@store');
        Route::post('/changeStatus', 'OrderController@changeStatus');
        Route::get('/callbackPay4Me', 'OrderController@callbackPay4Me');
        Route::post('/payWithPeer', 'OrderController@payWithPeer');
        Route::post('/payWithPaystack', 'OrderController@payWithPaystack');
        Route::post('/changeDayStatus', 'OrderController@changeDayStatus');
        Route::post('/assignRider', 'OrderController@assignRider');
        Route::post('/requestRider', 'OrderController@requestRider');
        Route::post('/rider/request', 'OrderController@riderRequest');
        Route::post('/assigned', 'OrderController@requestRider');
        Route::post('/storeTrackedDate', 'OrderController@storeTrackedDate');
        Route::post('/paystackWebhook', 'OrderController@paystackWebhook');
        Route::get('/fetchPackageOrder', 'OrderController@fetchPackageOrder');
        Route::get('/fetchDeliveryDays', 'OrderController@fetchDeliveryDays');
        Route::get('/', 'OrderController@getOrders')->middleware(['jwt', 'admin']);
        Route::post('/changePaymentStatus', 'OrderController@changePaymentStatus');
        Route::put('/{id}', 'OrderController@update')->middleware(['jwt', 'admin']);
        Route::post('/storePay4Me', 'OrderController@storePay4Me')->where('id', '\d+');
        Route::delete('/{id}', 'OrderController@destroy')->middleware(['jwt', 'admin']);
        Route::post('/changeTrackedDateStatus', 'OrderController@changeTrackedDateStatus');
        Route::get('/{id}', 'OrderController@show')->where('id', '\d+')->middleware(['jwt']);
        Route::get('/fetchTrackedDeliveryDates', 'OrderController@fetchTrackedDeliveryDates');
        Route::get('/verifyPayments', 'OrderController@verifyPayments');
        Route::get('/finance', 'OrderController@getOrderFinance');
    });

    // Event Orders routes
    Route::group([
        'prefix' => 'event-orders',
        'namespace' => 'Order'
    ], function () {
        Route::get('/', 'EventOrderController@index');
        Route::post('/', 'EventOrderController@store');
        Route::get('/{id}', 'EventOrderController@show');
        Route::put('/{id}', 'EventOrderController@update');
        Route::delete('/{id}', 'EventOrderController@destroy');
        Route::post('/changeStatus', 'EventOrderController@changeStatus');
        Route::post('/assignRider', 'EventOrderController@assignRider');
        Route::post('/changePaymentStatus', 'EventOrderController@changePaymentStatus');
    });

    // Corporate routes
    Route::group([
        'prefix' => 'corporate-orders',
        'namespace' => 'Order'
    ], function () {
        Route::get('/', 'CorporateOrderController@index');
        Route::post('/', 'CorporateOrderController@store');
        Route::get('/{id}', 'CorporateOrderController@show');
        Route::put('/{id}', 'CorporateOrderController@update');
        Route::delete('/{id}', 'CorporateOrderController@destroy');
        Route::post('/changeStatus', 'CorporateOrderController@changeStatus');
        Route::post('/assignRider', 'CorporateOrderController@assignRider');
        Route::post('/changePaymentStatus', 'CorporateOrderController@changePaymentStatus');
    });

    // Coupon routes
    Route::group([
        'prefix' => 'coupons',
        'namespace' => 'Coupon'
    ], function () {
        Route::get('/', 'CouponController@index')->middleware(['jwt', 'admin']);
        Route::post('/', 'CouponController@store')->middleware(['jwt', 'admin']);
        Route::get('/generate-report', 'CouponController@generateReport');
        Route::get('/{code}', 'CouponController@validateCoupon')->where('code', '.*');
    });

    // Contacts routes
    Route::group([
        'prefix' => 'contacts',
    ], function () {
        Route::get('/', 'ContactController@index');
        Route::post('/', 'ContactController@store');
        Route::get('/{code}', 'ContactController@show');
    });

    // BankAccounts routes
    Route::group([
        'prefix' => 'bank-accounts',
        'namespace' => 'Overview',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::get('/', 'BankAccountController@index');
        Route::post('/', 'BankAccountController@store');
        Route::post('/update', 'BankAccountController@update');
        Route::post('/store', 'BankAccountController@store');
    });

    // BankPayments routes
    Route::group([
        'prefix' => 'bank-payments',
        'namespace' => 'Overview',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::get('/', 'BankPaymentController@index');
        Route::post('/', 'BankPaymentController@store');
        Route::post('/update', 'BankPaymentController@update');
        Route::post('/store', 'BankPaymentController@store');
    });

    // Transactios routes
    Route::group([
        'prefix' => 'transactions',
        'namespace' => 'Transaction',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::post('/monnify/authenticate', 'TransactionController@authenticateMonnify');
        Route::post('/monnify', 'TransactionController@fetchMonnify');
        Route::post('/paystack', 'TransactionController@fetchPaystack');
    });

    // Report routes
    Route::group([
        'prefix' => 'report',
        'middleware' => ['jwt', 'admin']
    ], function () {
        Route::get('/fetchAllTotals/{startDate?}/{endDate?}', 'ReportController@allTotals');
        Route::get('/fetchPackageRevenue/{startDate?}/{endDate?}', 'ReportController@allPackageRevenue');
        Route::post('/fetchOrderRider', 'ReportController@orderRider');
        Route::post('/fetchOrderPerPeriod', 'ReportController@orderPerPeriod');
    });
});
