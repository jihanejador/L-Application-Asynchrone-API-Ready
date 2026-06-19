<?php
namespace App\Controller\Web;

use App\Service\AuthService;
use App\Config\Database;

class AdminController {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function showReports(): void {
        if (!$this->authService->isAuthenticated() || !$this->authService->hasRole(['admin'])) {
            header('Location: index.php?url=login');
            exit;
        }

        $db = Database::getConnection();

        $stmt = $db->query("SELECT SUM(quantite * 15) as perte_totale 
                            FROM lots 
                            WHERE statut = 'EXPIRED'");
        $data = $stmt->fetch();
        $perte = $data->perte_totale ?? 0;

        require_once __DIR__ . '/../../../templates/reports.php';
    }
}