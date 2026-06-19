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

require_once __DIR__ . '/../config/database.php';

use App\Controller\Web\AuthController;
use App\Controller\Web\AdminController;
use App\Controller\Api\ApiStockController;
use App\Controller\Api\ApiDashboardController;
use App\Service\AuthService;

$authService = new AuthService();

$route = '/';
if (isset($_GET['url'])) {
    $route = '/' . trim($_GET['url'], '/');
}
$method = $_SERVER['REQUEST_METHOD'];

if (strpos($route, '/api/v1') === 0 || $route === '/stock/add') {
    header('Content-Type: application/json');
    if ($route === '/stock/add' && $method === 'POST') {
        (new ApiStockController())->addBatch(); exit;
    }
    if ($route === '/api/v1/batches' && $method === 'GET') {
        (new ApiDashboardController())->getBatches(); exit;
    }
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Route non trouvée']); exit;
}

if ($route === '/login') {
    (new AuthController())->showLogin();
} elseif ($route === '/logout') {
    (new AuthController())->logout();
} elseif ($route === '/reports') {
    (new AdminController())->showReports();
} else {
    if (!$authService->isAuthenticated()) {
        header('Location: index.php?url=login');
        exit;
    }
    $user = $authService->getCurrentUser();
    require_once __DIR__ . '/../templates/dashboard.php';
}