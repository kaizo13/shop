<?php

use Illuminate\Http\Request;
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

//Article
    Route::post('/storeArticle','ArticleController@store');

//Brand
    Route::post('/storeBrand','BrandController@store');

//Cart
    Route::post('/storeCart','CartController@store');

//Comment
    Route::post('/storeComment','CommentController@store');
    Route::get('/getComments/{id}','CommentController@get');

//Customer
    Route::post('/storeCustomer','CustomerController@store');

//Product
    Route::post('/storeProduct','ProductController@store');
    Route::get('/getProduct/{id}','ProductController@get');
    Route::get('/getProducts','ProductController@getProducts');


//Valoration
    Route::post('/storeValoration','ValorationController@store');
    Route::post('/updateValoration/{id}','ValorationController@update');