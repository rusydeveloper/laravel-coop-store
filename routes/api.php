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


Route::get('/product', 'ApiController@product')->name('api_product');
Route::get('/product/category/{id}', 'ApiController@productCategory')->name('api_product_category');
Route::get('/product/search/{search}', 'ApiController@productSearch')->name('api_product_search');

Route::get('/category', 'ApiController@category')->name('api_category');
Route::get('/campaigns', 'ApiController@campaigns');
Route::get('/campaign/search/{search}', 'ApiController@campaignSearch')->name('api_campaign_search');
Route::get('/campaign/category/{id}', 'ApiController@campaignCategory')->name('api_campaign_category');

Route::get('/campaigns/supplier/{unique_id}', 'ApiController@campaignsSelectedSupplier');
Route::get('/campaign/search/{search}/supplier/{unique_id}', 'ApiController@campaignSearchSelectedSupplier')->name('api_campaign_search_selected_supplier');
Route::get('/campaign/category/{id}/supplier/{unique_id}', 'ApiController@campaignCategorySelectedSupplier')->name('api_campaign_category_selected_supplier');

Route::get('/invoice', 'ApiController@invoice')->name('api_invoice');
Route::get('/invoice/user/{user_id}', 'ApiController@invoiceUser')->name('api_invoice_user');

Route::get('/wallet/user/{user_id}', 'ApiController@checkWallet')->name('api_wallet_user');


Route::post('/order/add', 'ApiController@add_order')->name('api_add_order');

Route::post('/posts', 'ApiController@posts');

Route::post('/testrequest', 'ApiController@testrequest');
Route::post('/posts', 'ApiController@posts');
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
Route::post('order/email', 'OrderController@email');
Route::get('order/test', 'OrderController@test');

Route::get('tickets/', 'ApiController@getTicket');
Route::post('tickets/create', 'ApiController@createTicket');

Route::post('inventory/store', 'InventoryController@store');

Route::get('inventory/user/{user_id}', 'ApiController@inventory');
Route::get('inventory/product/{product_id}', 'InventoryController@show');
Route::get('inventory/history/user/{user_id}/product/{product_id}', 'ApiController@inventoryHistory');
Route::get('inventory/history/user/{user_id}/product/{product_id}/report', 'ApiController@inventoryHistoryReport');

Route::get('business/{unique_id}', 'ApiController@businessSelected');

Route::get('logout', 'AuthController@logout');
Route::get('user', 'AuthController@user');