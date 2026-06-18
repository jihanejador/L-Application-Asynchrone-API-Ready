<?php
namespace App\Controller\Api;

use App\Service\AuthService;
use App\Config\Database;
use PDO;

class ApiDashboardController{
    private AuthService $authService;
    private PDO $db;

    public function __construct(){
        $this->authService = new AuthService();
        $this->db = Database::getConnection();
    }

    public function getBatches(): void{
        $this->authService->checkRoleOrAbort('PHARMACIEN');

        $criteria = $_GET['criteria'] ?? 'all';

        if($criteria === 'critical'){
            $stmt = $this->db->prepare("
                SELECT b.*, m.name as medicament_name FROM batches b
                JOIN medicaments m ON b.medicament_id = m.id
                WHERE b.date_peremption <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) AND b.quantity > 0
                ORDER BY b.date_peremption ASC
            ");
        } else {
            $stmt = $this->db->prepare("
                SELECT b.*, m.name as medicament_name FROM batches b
                JOIN medicaments m ON b.medicament_id = m.id
                ORDER BY b.date_peremption ASC
            ");
        }
        $stmt->execute();
        $batches = $stmt->fetchAll();
    }
}