<?php
namespace App\Controller\Api;

use App\Service\AuthService;
use App\Service\StockService;

class ApiStockController{
    private AuthService $authService;
    private StockService $stockService;

    public function __construct(){
        $this->authService = new AuthService();
        $this->stockService = new StockService();
    }
}