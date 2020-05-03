<?php

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




Auth::routes();


// Route::get('/', 'PageController@landing')->name('landing');

Route::get('/', 'HomeController@index')->name('landing');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/back', 'HomeController@back_to')->name('back_to');
Route::get('/cards/', 'CardController@index')->name('card_index');
Route::post('/cards/order/', 'CardController@order')->name('card_order');
Route::post('/cards/order/submit', 'CardController@store')->name('card_order_submit');

// ADMIN ROUTE
Route::group(['middleware' => ['auth']], function () {
	Route::group(['middleware' => ['CheckAdmin']], function () {
		Route::prefix('admin')->group(function () {
			Route::get('/', 'AdminController@index')->name('admin');
			Route::get('/user', 'AdminController@user')->name('admin_user');
			Route::get('/user/create', 'AdminController@user_create');
			Route::post('/user/edit', 'AdminController@user_edit');
			Route::post('/user/store', 'AdminController@user_store');
			Route::post('/user/update', 'AdminController@user_update')->name('admin_user_update');
			Route::post('/user/delete', 'AdminController@user_delete');
			Route::post('/user/reset-password', 'AdminController@user_reset_password');
			Route::post('/user/user-reset-password-submit', 'AdminController@user_reset_password_submit')->name('user_reset_password_submit');

			Route::get('/business', 'AdminController@business')->name('admin_business');
			Route::get('/business/create', 'AdminController@business_create');
			Route::post('/business/edit', 'AdminController@business_edit');
			Route::post('/business/store', 'AdminController@business_store');
			Route::post('/business/update', 'AdminController@business_update');
			Route::post('/business/delete', 'AdminController@business_delete');

			Route::get('/category', 'AdminController@category')->name('admin_category');
			Route::get('/category/create', 'AdminController@category_create');
			Route::post('/category/edit', 'AdminController@category_edit');
			Route::post('/category/store', 'AdminController@category_store');
			Route::post('/category/update', 'AdminController@category_update');
			Route::post('/category/delete', 'AdminController@category_delete');

			Route::get('/product', 'AdminController@product')->name('admin_product');
			Route::get('/product/create', 'AdminController@product_create');
			Route::post('/product/edit', 'AdminController@product_edit');
			Route::post('/product/search', 'AdminController@product_search')->name('admin_product_search');
			Route::post('/product/store', 'AdminController@product_store');
			Route::post('/product/update', 'AdminController@product_update');
			Route::post('/product/delete', 'AdminController@product_delete');
			Route::post('/product/activate', 'AdminController@product_activate');
			Route::post('/product/deactivate', 'AdminController@product_deactivate');
//CAMPAIGN
			Route::get('/campaign', 'CampaignController@campaign')->name('admin_campaign');
			Route::get('/campaign/create', 'CampaignController@campaign_create');
			Route::post('/campaign/edit', 'CampaignController@campaign_edit');
			Route::post('/campaign/search', 'CampaignController@campaign_search')->name('admin_campaign_search');
			Route::post('/campaign/store', 'CampaignController@campaign_store');
			Route::post('/campaign/update', 'CampaignController@campaign_update');
			Route::post('/campaign/delete', 'CampaignController@campaign_delete');
			Route::post('/campaign/activate', 'CampaignController@campaign_activate');
			Route::post('/campaign/deactivate', 'CampaignController@campaign_deactivate');
//WALLET
			Route::get('/wallet', 'WalletController@wallet')->name('admin_wallet');
			Route::post('/wallet/edit', 'WalletController@wallet_edit');
			Route::post('/wallet/update', 'WalletController@wallet_update');

			Route::get('/package', 'AdminController@package')->name('admin_package');
			Route::get('/package/create', 'AdminController@package');
			Route::post('/package/edit', 'AdminController@package_edit');
			Route::post('/package/store', 'AdminController@package_store');
			Route::post('/package/update', 'AdminController@package_update');
			Route::post('/package/delete', 'AdminController@package_delete');

			Route::get('/order', 'AdminController@order')->name('admin_order');
			Route::get('/order/create', 'AdminController@order');
			Route::post('/order/edit', 'AdminController@order_edit');
			Route::post('/order/store', 'AdminController@order_store');
			Route::post('/order/update', 'AdminController@order_update');
			Route::post('/order/delete', 'AdminController@order_delete');

			Route::get('/payment', 'AdminController@payment')->name('admin_payment');
			Route::get('/payment/create', 'AdminController@payment_create');
			Route::post('/payment/edit', 'AdminController@payment_edit');
			Route::post('/payment/store', 'AdminController@payment_store');
			Route::post('/payment/update', 'AdminController@payment_update');
			Route::post('/payment/delete', 'AdminController@payment_delete');

			Route::get('/report', 'AdminController@report')->name('admin_report');
			Route::get('/report/create', 'AdminController@report');
			Route::get('/report/edit', 'AdminController@report_edit');
			Route::post('/report/store', 'AdminController@report_store');
			Route::post('/report/update', 'AdminController@report_update');
			Route::post('/report/delete', 'AdminController@report_delete');

			// ADMIN INVOICES
			Route::get('/invoice', 'AdminController@invoice')->name('admin_invoice');
			Route::post('/invoice/cancel', 'AdminController@admin_invoice_cancel')->name('admin_invoice_cancel');
			Route::post('/invoice/paid', 'AdminController@admin_invoice_paid')->name('admin_invoice_paid');

			Route::get('/invoice/discount', 'AdminController@admin_invoice_discount')->name('admin_invoice_discount');

			// ADMIN DISCOUNT
			Route::post('/invoice/discount/approve', 'AdminController@admin_invoice_approve')->name('admin_invoice_approve');
			Route::post('/invoice/discount/reject', 'AdminController@admin_invoice_reject')->name('admin_invoice_reject');

			//REPORTING
			Route::post('/report/daily', 'AdminController@report_daily')->name('report_daily');
			Route::post('report/order/daily/supplier', 'AdminController@report_daily_supplier_order')->name('report_daily_supplier');
			Route::post('report/order/daily/supplier/cooperative', 'AdminController@report_daily_supplier_order_cooperative')->name('report_daily_supplier_cooperative');
			Route::post('/report/weekly', 'AdminController@report_weekly')->name('report_weekly');
			
			Route::post('/report/monthly', 'AdminController@report_monthly')->name('report_monthly');
			Route::post('/report/yearly', 'AdminController@report_yearly')->name('report_yearly');
			Route::post('/report/periodic', 'AdminController@report_periodic')->name('report_periodic');

			Route::post('report/order/periodic/supplier', 'AdminController@report_periodic_supplier_order')->name('report_periodic_supplier');
			Route::post('report/order/periodic/supplier/cooperative', 'AdminController@report_periodic_supplier_order_cooperative')->name('report_periodic_supplier_cooperative');
		});

});

Route::group(['middleware' => ['CheckCashier']], function () {
	Route::prefix('cashier')->group(function () {
		//CASHIER
		Route::get('/', 'CashierController@cashier_order')->name('cashier');
		Route::get('/order', 'CashierController@cashier_order')->name('cashier_order');
		Route::post('/invoice/payment', 'CashierController@cashier_payment')->name('cashier_payment');
		Route::post('/invoice/paid', 'CashierController@cashier_paid')->name('cashier_paid');
		Route::post('/invoice/show', 'CashierController@cashier_show')->name('cashier_show');
		Route::get('/report', 'CashierController@cashier_report')->name('cashier_report');
		Route::post('/report/daily', 'CashierController@report_daily')->name('cashier_report_daily');
		Route::post('/report/weekly', 'CashierController@report_weekly')->name('cashier_report_weekly');
		Route::post('/report/monthly', 'CashierController@report_monthly')->name('cashier_report_monthly');
		Route::post('/report/periodic', 'CashierController@report_periodic')->name('cashier_report_periodic');

		Route::post('/discount/{unique_id}', 'CashierController@discount_request');

		Route::post('/discount/verify/{unique_id}', 'CashierController@discount_verify');
	});
});

Route::group(['middleware' => ['CheckManager']], function () {
	Route::prefix('manager')->group(function () {
		Route::get('/', 'ManagerController@manager_order')->name('manager');
		Route::get('/recap', 'ManagerController@manager_recap')->name('manager_recap');
		Route::post('/recap/order', 'ManagerController@manager_recap_order');
		Route::post('/recap/submit', 'ManagerController@manager_recap_submit');
		Route::get('/order', 'ManagerController@manager_order')->name('manager_order');
		Route::post('/invoice/payment', 'ManagerController@manager_payment')->name('manager_payment');
		Route::post('/invoice/paid', 'ManagerController@manager_paid')->name('manager_paid');
		Route::post('/invoice/show', 'ManagerController@manager_show')->name('manager_show');
		Route::get('/report', 'ManagerController@manager_report')->name('manager_report');
		Route::post('/report/daily', 'ManagerController@report_daily')->name('manager_report_daily');
		Route::post('/report/weekly', 'ManagerController@report_weekly')->name('manager_report_weekly');
		Route::post('/report/monthly', 'ManagerController@report_monthly')->name('manager_report_monthly');
		Route::post('/report/periodic', 'ManagerController@report_periodic')->name('manager_report_periodic');

		Route::post('/discount/{unique_id}', 'ManagerController@discount_request');

		Route::post('/discount/verify/{unique_id}', 'ManagerController@discount_verify');
	});
});


Route::group(['middleware' => ['CheckTenant']], function () {
	Route::prefix('tenant')->group(function () {
    //TENANT ROUTE
		Route::get('/', 'TenantController@tenant_card_index')->name('tenant');

		Route::get('/user', 'TenantController@user')->name('tenant_user');
		Route::post('/user/edit', 'TenantController@user_edit');
		Route::post('/user/update', 'TenantController@user_update')->name('tenant_user_update');
		Route::post('/user/reset-password', 'TenantController@user_reset_password');
		Route::post('/user/user-reset-password-submit', 'TenantController@user_reset_password_submit')->name('user_reset_password_submit');

		Route::get('/business', 'TenantController@business')->name('tenant_business');
		Route::get('/business/create', 'TenantController@business_create');
		Route::post('/business/edit', 'TenantController@business_edit');
		Route::post('/business/store', 'TenantController@business_store');
		Route::post('/business/update', 'TenantController@business_update');
		Route::post('/business/delete', 'TenantController@business_delete');

		Route::get('/product', 'TenantController@product')->name('tenant_product');
		Route::get('/product/create', 'TenantController@product_create');
		Route::post('/product/edit', 'TenantController@product_edit');
		Route::post('/product/store', 'TenantController@product_store');
		Route::post('/product/update', 'TenantController@product_update');
		Route::post('/product/delete', 'TenantController@product_delete');
	

		Route::get('/order', 'TenantController@order')->name('tenant_order');
		Route::post('/order/store', 'TenantController@order_store');
		Route::post('/order/submit', 'TenantController@order_submit');
		Route::post('/order/update', 'TenantController@order_update');
		Route::get('/invoice', 'TenantController@invoice')->name('tenant_invoice');

//REPORTING
		Route::get('/report', 'TenantController@report')->name('tenant_report');
		Route::post('/report/daily', 'TenantController@report_daily')->name('report_daily');
		Route::post('/report/weekly', 'TenantController@report_weekly')->name('report_weekly');
		Route::post('/report/monthly', 'TenantController@report_monthly')->name('report_monthly');
		Route::post('/report/periodic', 'TenantController@report_periodic')->name('report_periodic');

		Route::get('/cards/', 'TenantController@tenant_card_index')->name('tenant_card_index');
Route::post('/cards/order/', 'TenantController@tenant_card_order')->name('tenant_card_order');
Route::post('/cards/order/submit', 'TenantController@tenant_card_store')->name('tenant_card_order_submit');
	});


});

});



// ============================= NO AUTH MIDDLEWARE ===============
Route::get('/product/show/{unique_id}', 'ProductController@show');



// ORDER ROUTE
Route::prefix('order')->group(function () {
	Route::get('/', 'OrderController@index')->name('order');
	Route::post('/add', 'OrderController@add');
	Route::get('/create', 'OrderController@create');
	Route::get('/edit', 'OrderController@edit');
	Route::post('/store', 'OrderController@store');
	Route::post('/update', 'OrderController@update');
	Route::post('/delete', 'OrderController@delete');
	Route::post('/submit', 'OrderController@submit');

	Route::get('/cart', 'OrderController@cart')->name('cart');
	Route::get('/submit', 'OrderController@complete')->name('cart_complete');
	Route::post('/detail', 'OrderController@detail');
});
Route::get('/cart/delete', 'OrderController@cart_delete');
Route::post('/cart/remove', 'OrderController@cart_remove');
Route::post('/cart/minus', 'OrderController@cart_minus');
Route::post('/cart/plus', 'OrderController@cart_plus');

// USER ROUTE
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/create', 'UserController@create');
Route::post('/user/edit', 'UserController@edit');
Route::post('/user/store', 'UserController@store');
Route::post('/user/update', 'UserController@update');
Route::post('/user/delete', 'UserController@delete');

// BUSINESS ROUTE
Route::get('/business', 'BusinessController@index')->name('business');
Route::get('/business/create', 'BusinessController@create');
Route::get('/business/edit', 'BusinessController@edit');
Route::post('/business/store', 'BusinessController@store');
Route::post('/business/update', 'BusinessController@update');
Route::post('/business/delete', 'BusinessController@delete');

// PRODUCT ROUTE
Route::get('/product', 'ProductController@index')->name('product');
Route::get('/product/create', 'ProductController@create');
Route::get('/product/edit', 'ProductController@edit');

Route::post('/product/store', 'ProductController@store');
Route::post('/product/update', 'ProductController@update');
Route::post('/product/delete', 'ProductController@delete');

// PACKAGE ROUTE
Route::get('/package', 'PackageController@index')->name('package');
Route::get('/package/create', 'PackageController@create');
Route::get('/package/edit', 'PackageController@edit');
Route::post('/package/store', 'PackageController@store');
Route::post('/package/update', 'PackageController@update');
Route::post('/package/delete', 'PackageController@delete');



// PAYMENT ROUTE
Route::get('/payment', 'PaymentController@index')->name('payment');
Route::get('/payment/create', 'PaymentController@create');
Route::post('/payment/edit', 'PaymentController@edit');
Route::post('/payment/store', 'PaymentController@store');
Route::post('/payment/update', 'PaymentController@update');
Route::post('/payment/delete', 'PaymentController@delete');

// REPORT ROUTE
Route::get('/report', 'ReportController@index')->name('report');
Route::get('/report/create', 'ReportController@create');
Route::get('/report/edit', 'ReportController@edit');
Route::post('/report/store', 'ReportController@store');
Route::post('/report/update', 'ReportController@update');
Route::post('/report/delete', 'ReportController@delete');

// Route::fallback(function () {
//     return view('errors.error');
// });

//NOTIFICATION
Route::get('/notifications', 'NotificationController@getIndex');
Route::post('/notifications/notify', 'NotificationController@getIndex');

//REALTIME LEARN
Route::get('/bridge-event', 'RealTimeController@event');

Route::get('/bridge-trial', 'RealTimeController@trial');

Route::get('/mychannel', 'RealTimeController@mychannel');

Route::get('/waiting', 'RealTimeController@waiting');


