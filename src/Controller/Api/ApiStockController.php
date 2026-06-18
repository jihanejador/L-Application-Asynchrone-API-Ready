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

    public function addBatch(): void{
        $this->authService->checkRoleOrAbort('PREPARATEUR');

        $medicamentId = $_POST['medicament_id'] ?? null;
        $quantite = $_POST['quantite'] ?? null;
        $datePeremption = $_POST['date_peremption'] ?? null;
        $numLot = $_POST['num_lot'] ?? null;

        if(!$medicamentId || !$quantite || !$datePeremption || !$numLot){
            header('HTTP/1.1 400 Bad Request');
            echo json_decode(['error' => 'Donnees incompletes'])
            return;
        }
    }
}