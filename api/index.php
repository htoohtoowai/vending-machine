<?php

require '../vendor/autoload.php';
require '../Router.php';

$router = new Router();

// Load API routes
require '../api/routes/api_routes.php';

// Dispatch request
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
