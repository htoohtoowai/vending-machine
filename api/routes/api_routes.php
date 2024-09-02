<?php

$router->addRoute('POST', '/api/v1/login', 'Api\Controllers\AuthController@login');
$router->addRoute('POST', '/api/v1/logout', 'Api\Controllers\AuthController@logout');
$router->addRoute('GET', '/api/v1/products', 'Api\Controllers\ProductsController@getProducts');
$router->addRoute('GET', '/api/v1/products/{id}', 'Api\Controllers\ProductsController@getProduct');
$router->addRoute('POST', '/api/v1/transactions', 'Api\Controllers\TransactionsController@createTransaction');

?>
