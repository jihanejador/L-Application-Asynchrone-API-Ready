<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\Web\AuthController;
use App\Controller\Web\AdminController;
use App\Controller\Api\ApiStockController;
use App\Controller\Api\ApiDshboardController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (strpos($uri, '/api/v1') === 0 || $uri === '/stock/add'){
    header('Content-Type: application/json');
    if($uri === '/sstock/add' && $method === 'POST'){
        $controller = new ApiStockController();
        $controller->addBatch();
        exit;
    }

    if($uri === '/api/v1/batches' && $method === 'GET'){
        $controller = new ApiDshboardController();
        $controller->getBatches();
        exit;
    }

    if($uri === '/api/v1/batches/checkout' && ($method === 'POST' || $method === 'PATCH')){
        $controller = new ApiStockController();
        $controller->checkout();
        exit;
    }

    if($uri === '/api/v1/batches/destroy' && $method === 'POST'){
        $controller = new ApiStockController();
        $controller->destroyBatch();
        exit;
    }

    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Route API non trouvee']);
    exit;
}

if($uri === '/login'){
    $controller = new AuthController();
    $controller->showLogin();
} elseif ($uri === '/admin/reports'){
    $controller = new AdminController();
    $controller->showReports();
} else {
    echo "<h1>Page d'accueil / Dashboard HTML Initial</h1><p>Connectez-vous pour voir l'application.</p>";
}
