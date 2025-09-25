<?php
session_start();

require_once __DIR__ . '/app/Core/Autoloader.php';

use App\Core\Autoloader;
use App\Core\Router;

Autoloader::register();

$router = new Router();

$router->setDefaultRoute('Product', 'index');

$router->add('/', 'Product', 'index', 'GET');
$router->add('/product', 'Product', 'index', 'GET');
$router->add('/product/create', 'Product', 'create', 'GET');
$router->add('/product/create', 'Product', 'create', 'POST');
$router->add('/product/edit/{id}', 'Product', 'edit', 'GET');
$router->add('/product/edit/{id}', 'Product', 'edit', 'POST');
$router->add('/product/delete/{id}', 'Product', 'delete', 'POST');

$router->add('/category', 'Category', 'index', 'GET');
$router->add('/category/create', 'Category', 'create', 'GET');
$router->add('/category/create', 'Category', 'create', 'POST');
$router->add('/category/edit/{id}', 'Category', 'edit', 'GET');
$router->add('/category/edit/{id}', 'Category', 'edit', 'POST');
$router->add('/category/delete/{id}', 'Category', 'delete', 'POST');

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);