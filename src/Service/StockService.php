<?php
namespace App\Service;

use App\Config\Database;
use PDO;

class StockService{
    private PDO $db;

    public function __construct(){
        $this->db = Database::getConnection();
    }

    public function insertBatch(int $medicamentId, int $quantite, string $datePeremption, string $numLot): bool {
        $stmt = $this->db->prepare("
        INSERT INTO batches (medicament_id, quantity, date_peremption, num_lot, status)
        VALUES (:med_id, :qty, :date_p, :num_l, 'AVAILABLE')
        ");
        return $stmt->execute([
            'med_id' => $medicamentId,
            'qty' => $quantite,
            'date_p' => $datePeremption,
            'num_l' => $numLot
        ]);
    }
}