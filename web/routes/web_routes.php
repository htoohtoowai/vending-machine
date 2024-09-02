<?php

$router->addRoute('GET', '/', 'Web\Controllers\AdminController@login');
$router->addRoute('GET', '/admin', 'Web\Controllers\AdminController@login');
$router->addRoute('GET', '/admin/login', 'Web\Controllers\AdminController@login');
$router->addRoute('POST', '/admin/login', 'Web\Controllers\AdminController@login');
$router->addRoute('POST', '/admin/logout', 'Web\Controllers\AdminController@logout');
$router->addRoute('GET', '/admin/dashboard', 'Web\Controllers\AdminController@dashboard');


$router->addRoute('GET', '/products', 'Web\Controllers\ProductsController@index');
$router->addRoute('GET', '/products/create', 'Web\Controllers\ProductsController@create');
$router->addRoute('POST', '/products/create', 'Web\Controllers\ProductsController@create');
$router->addRoute('GET', '/products/{id}/edit', 'Web\Controllers\ProductsController@edit');
$router->addRoute('POST', '/products/{id}/update', 'Web\Controllers\ProductsController@update');
$router->addRoute('POST', '/products/{id}/delete', 'Web\Controllers\ProductsController@delete');



$router->addRoute('GET', '/users', 'Web\Controllers\UsersController@index');
$router->addRoute('GET', '/users/{id}', 'Web\Controllers\UsersController@show');
$router->addRoute('GET', '/users/create', 'Web\Controllers\UsersController@create');
$router->addRoute('POST', '/users/create', 'Web\Controllers\UsersController@create');
$router->addRoute('GET', '/users/{id}/edit', 'Web\Controllers\UsersController@edit');
$router->addRoute('POST', '/users/{id}/update', 'Web\Controllers\UsersController@edit');
$router->addRoute('POST', '/users/{id}/delete', 'Web\Controllers\UsersController@delete');

$router->addRoute('GET', '/transactions', 'Web\Controllers\TransactionsController@index');
$router->addRoute('GET', '/transactions/{id}', 'Web\Controllers\TransactionsController@show');
$router->addRoute('GET', '/transactions/create', 'Web\Controllers\TransactionsController@create');
$router->addRoute('POST', '/transactions/create', 'Web\Controllers\TransactionsController@create');
$router->addRoute('GET', '/transactions/{id}/edit', 'Web\Controllers\TransactionsController@edit');
$router->addRoute('POST', '/transactions/{id}/update', 'Web\Controllers\TransactionsController@edit');
$router->addRoute('POST', '/transactions/{id}/delete', 'Web\Controllers\TransactionsController@delete');



