<?php

use Illuminate\Http\Request;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['middleware' => ['auth:api']], function () {
// Route::get('/user', 'ApiController@user')->name('api_user');
// Route::get('/business', 'ApiController@business')->name('api_user');

// Route::get('/invoice', 'ApiController@invoice')->name('api_invoice');
// Route::get('/order', 'ApiController@order')->name('api_order');


// });

// Route::post('/login', 'ApiController@login');

Route::get('/product/{unique_id}', 'ApiController@tenantProduct');
Route::get('/invoice/{unique_id}', 'ApiController@tenantInvoice');
Route::get('report/{unique_id}', 'ApiController@tenantReport');
Route::get('report/invoice/{unique_id}', 'ApiController@tenantReportInvoice');
Route::get('tenant/invoice/detail/{unique_id}', 'ApiController@tenantInvoiceDetail');

Route::post('/tenantOrder', 'ApiController@tenantOrder');

Route::get('cashier/invoice/{unique_id}', 'ApiController@cashierInvoice');
Route::get('cashier/invoice/detail/{unique_id}', 'ApiController@cashierInvoiceDetail');
Route::get('cashier/invoice/order/{unique_id}', 'ApiController@cashierOrderDetail');
Route::get('cashier/report/{unique_id}', 'ApiController@cashierReport');
Route::get('cashier/report/invoice/{unique_id}', 'ApiController@cashierReportInvoice');

Route::post('cashierPayment', 'ApiController@cashierPayment');

Route::get('/product', 'ApiController@product')->name('api_product');
Route::get('/product/category/{id}', 'ApiController@productCategory')->name('api_product_category');
Route::get('/product/search/{search}', 'ApiController@productSearch')->name('api_product_search');

Route::get('/category', 'ApiController@category')->name('api_category');

// Route::get('/product/{unique_id}', 'ApiController@productDetail');
Route::post('/order/add', 'ApiController@add_order')->name('api_add_order');

Route::post('/posts', 'ApiController@posts');

Route::get('/testuser', 'ApiController@testuser');
Route::post('/testuser', 'ApiController@testuser');
Route::post('/testpost', 'ApiController@testpost')->name('api_testpost');
Route::post('/testrespond', 'ApiController@testrespond');
Route::post('/testrequest', 'ApiController@testrequest');


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');


  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('test', 'AuthController@testAPInew');
        Route::get('logout', 'AuthController@logout');
    });
});

Route::post('order/submit', 'OrderController@submit');
Route::get('order/test', 'OrderController@test');

Route::get('logout', 'AuthController@logout');
Route::get('user', 'AuthController@user');
