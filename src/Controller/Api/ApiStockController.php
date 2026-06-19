<?php
namespace App\Controller\Api;

use App\Service\StockService;
use App\Service\AuthService;

class ApiStockController {
    private StockService $stockService;
    private AuthService $authService;

    public function __construct() {
        $this->stockService = new StockService();
        $this->authService = new AuthService();
    }

    public function addBatch(): void {
        if (!$this->authService->hasRole(['admin', 'preparateur'])) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['error' => 'Action non autorisée']);
            exit;
        }

        $medicament_id = $_POST['medicament_id'] ?? null;
        $numero_lot = $_POST['numero_lot'] ?? null;
        $quantite = $_POST['quantite'] ?? null;
        $date_peremption = $_POST['date_peremption'] ?? null;

        if ($medicament_id && $numero_lot && $quantite && $date_peremption) {
            $success = $this->stockService->createLot([
                'medicament_id' => $medicament_id,
                'numero_lot' => $numero_lot,
                'quantite' => $quantite,
                'date_peremption' => $date_peremption
            ]);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Lot ajouté avec succès']);
            } else {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'Erreur lors de l\'ajout']);
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Données incomplètes']);
        }
    }
}