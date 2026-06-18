<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Web\AuthController;
use App\Controller\Web\AdminController;
use App\Controller\Api\ApiStockController;
use App\Controller\Api\ApiDshboardController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


