<?php

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::apiResource('products', 'ProductController');

/**For prefixing like /products/{product}/reviews/{review}*/
Route::group(['prefix' => 'products'], function () {
    Route::apiResource('/{product}/reviews', 'ReviewController');
});