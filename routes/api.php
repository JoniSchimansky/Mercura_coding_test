<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Endpoint to create a new quote
    Route::post('/quotes', 'App\Http\Controllers\ApiController@storeQuote');

    // Endpoint to list all products with the basic information
    Route::get('/products', 'App\Http\Controllers\ApiController@indexProducts');

    // Endpoint to get detailed information for a specific product
    Route::get('/product/{product_id}', 'App\Http\Controllers\ApiController@showProduct');
});
