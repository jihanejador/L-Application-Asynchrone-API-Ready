<?php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) { require_once $file; }
});

use App\Controller\Web\AuthController;
use App\Controller\Web\AdminController;
use App\Controller\Api\ApiStockController;
use App\Controller\Api\ApiDashboardController;

$route = '/';
if (isset($_GET['url'])) {
    $route = '/' . trim($_GET['url'], '/');
}

$method = $_SERVER['REQUEST_METHOD'];

if (strpos($route, '/api/v1') === 0 || $route === '/stock/add') {
    header('Content-Type: application/json');
    
    if ($route === '/stock/add' && $method === 'POST') {
        $controller = new ApiStockController();
        $controller->addBatch();
        exit;
    }

    if ($route === '/api/v1/batches' && $method === 'GET') {
        $controller = new ApiDashboardController();
        $controller->getBatches();
        exit;
    }

    if ($route === '/api/v1/batches/checkout' && ($method === 'POST' || $method === 'PATCH')) {
        $controller = new ApiStockController();
        $controller->checkout();
        exit;
    }

    if ($route === '/api/v1/batches/destroy' && $method === 'POST') {
        $controller = new ApiStockController();
        $controller->destroyBatch();
        exit;
    }

    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Route API non trouvee']);
    exit;
}

if ($route === '/login') {
    $controller = new AuthController();
    $controller->showLogin();
} elseif ($route === '/admin/reports') {
    $controller = new AdminController();
    $controller->showReports();
} else {
    echo "<h1>Page d'accueil / Dashboard HTML Initial</h1><p>Connectez-vous pour voir l'application.</p>";
}