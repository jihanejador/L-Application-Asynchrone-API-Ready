<?php
namespace App\Controller\Api;

use App\Service\AuthService;
use App\Service\StockService;

class ApiStockController {
    private AuthService $authService;
    private StockService $stockService;

    public function __construct() {
        $this->authService = new AuthService();
        $this->stockService = new StockService();
    }

    public function addBatch(): void {
        $this->authService->checkRoleOrAbort('PREPARATEUR');

        $medicamentId = $_POST['medicament_id'] ?? null;
        $quantite = $_POST['quantite'] ?? null;
        $datePeremption = $_POST['date_peremption'] ?? null;
        $numLot = $_POST['num_lot'] ?? null;

        if (!$medicamentId || !$quantite || !$datePeremption || !$numLot) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Donnees incompletes']);
            return;
        }

        $success = $this->stockService->insertBatch((int)$medicamentId, (int)$quantite, $datePeremption, $numLot);

        if ($success) {
            echo json_encode(['status' => 'success', 'message' => 'Lot ajoute de maniere asynchrone !']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Erreur lors de l\'insertion']);
        }
    }

    public function checkout(): void {
        $this->authService->checkRoleOrAbort('PREPARATEUR');

        $input = json_decode(file_get_contents('php://input'), true);
        $medicamentId = $input['medicament_id'] ?? null;

        if (!$medicamentId) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'ID Medicament requis']);
            return;
        }
        
        $result = $this->stockService->deliverOneBoxFEFO((int)$medicamentId);

        if ($result) {
            echo json_encode(['status' => 'success', 'data' => $result]);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Stock épuisé (Règle FEFO) !']);
        }
    }

    public function destroyBatch(): void {
        $this->authService->checkRoleOrAbort('PHARMACIEN');

        $input = json_decode(file_get_contents('php://input'), true);
        $batchId = $input['batch_id'] ?? null;

        if (!$batchId) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'ID du Lot requis']);
            return;
        }
        
        $success = $this->stockService->forceDestroyBatch((int)$batchId);

        if ($success) {
            echo json_encode(['status' => 'success', 'message' => 'Lot marqué EXPIRED. Quantité à 0.']);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Impossible de détruire ce lot']);
        }
    }
}