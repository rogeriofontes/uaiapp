<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'FrontController@index');
Route::get('/edit-announcement/{id}', ['uses' => 'FrontController@editAnnouncement', function($id){}])->middleware('auth:api');
Route::get('/announcement', 'FrontController@announcement')->middleware('auth:api');
Route::get('/planos', 'FrontController@plan')->middleware('auth:api');
Route::get('/checkout', 'FrontController@checkout')->middleware('auth:api');
Route::get('/cartao', 'FrontController@creditCard')->middleware('auth:api');
Route::get('/checkout/sucesso', 'FrontController@checkoutSuccess')->middleware('auth:api');
Route::post('set-checkout', 'FrontController@setCheckout')->middleware('auth:api');
Route::post('set-announcement', 'FrontController@setAnnouncement')->middleware('auth:api');
Route::post('set-credit-card', 'FrontController@setCreditCard')->middleware('auth:api');
Route::post('/update-announcement/{id}', ['uses' => 'FrontController@updateAnnouncement', function($id){}]);
Route::post('get-product-subcategories', 'AjaxController@getProductSubcategories');
Route::post('get-cep', 'AjaxController@getCep');

//checkouts
Route::group(['prefix' => 'pagseguro'], function(){
    Route::post('return', 'PagSeguroController@returnInfo');
    Route::post('payment', 'PagSeguroController@payment');
});


Route::group(['prefix' => 'painel'], function () {

    Auth::routes();
    
    Route::resource('/', 'HomeController');
    Route::resource('user', 'UserController');
    Route::resource('menu', 'MenuController');
    Route::resource('role', 'RoleController');

    Route::resource('news', 'NewsController');
    Route::resource('news-category', 'NewsCategoryController');
    Route::resource('banner', 'BannerController');
    Route::resource('store', 'StoreController');
    Route::resource('plan', 'PlanController');

    Route::resource('products', 'ProductController');
    Route::resource('product-category', 'ProductCategoryController');
    Route::resource('product-sub-category', 'ProductSubCategoryController');

    Route::resource('interests', 'InterestController');

    Route::resource('users-app', 'UserAppController');
    Route::resource('notifications', 'NotificationController');

    Route::resource('media', 'MediaController');

    Route::resource('checkout', 'CheckoutController');

    //ERRORS
    Route::get('403', function(){return view('errors.403');});
    Route::get('404', function(){return view('errors.404');});
    Route::get('500', function(){return view('errors.500');});

    //AJAX
    Route::post('get-cep', 'AjaxController@getCep');
    Route::post('get-company', 'AjaxController@getCompany');
    Route::post('get-product-subcategories', 'AjaxController@getProductSubcategories');
    Route::post('update-interest-status', 'AjaxController@updateInterestStatus');
});