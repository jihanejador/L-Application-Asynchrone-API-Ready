<?php
namespace App\Controller\Api;

use App\Service\StockService;

class ApiDashboardController {
    private StockService $stockService;

    public function __construct() {
        $this->stockService = new StockService();
    }

    public function getBatches(): void {
        $criteria = $_GET['criteria'] ?? 'all';
        $data = $this->stockService->getDashboardData($criteria);
        echo json_encode($data);
    }
}