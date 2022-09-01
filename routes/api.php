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

Route::group(array('prefix' => 'v1'), function(){

    Route::get('/', function () {
        return response()->json(['message' => 'UAI APP API v1', 'status' => 'Connected']);;
    });

    //ROUTES WITHOUT MIDDLEAWARE
    Route::get('get-banners', 'WsController@getBanners');
    Route::get('getnews', 'WsController@getNews');
    Route::get('getproductscategory', 'WsController@getProductCategory');
    Route::get('getproducts/{subcategory}', ['uses' => 'WsController@getProducts', function($subCategory){}]);
    Route::get('get-store', 'WsController@getStore');
    Route::get('get-store-products/{store}', ['uses' => 'WsController@getStoreProducts', function($store){}]);
    Route::get('get-weather', 'WsController@getWeather');

    Route::post('authenticate', 'WsController@authenticate');
    Route::post('register', 'WsController@register');
    Route::post('forgot-password', 'WsController@forgotPassword');
    Route::post('recover-password', 'WsController@recoverPassword');
    Route::post('validate', 'WsController@validateUser');
    Route::post('recover-validate', 'WsController@recoverValidate');

    //ROUTES WITH MIDDLEAWARE
    Route::post('set-want-product/{idproduct}', ['uses' => 'WsController@setWantProduct', function($idProduct){}])->middleware('auth:api');
    Route::post('set-product', 'WsController@setProduct')->middleware('auth:api');
    Route::post('set-user', "WsController@alterUser")->middleware('auth:api');
    Route::get('get-announcements', 'WsController@getAnnouncements')->middleware('auth:api');

    Route::get('forgot', function(){
        return view('emails.forgot-password')->with('user', App\User::find(1));
    });
});