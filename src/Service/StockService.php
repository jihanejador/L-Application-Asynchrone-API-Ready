<?php
namespace App\Service;

use App\Config\Database;

class StockService {

    public function getDashboardData(string $criteria): array {
        $db = Database::getConnection();
        
        $statsStmt = $db->query("SELECT COUNT(*) as total FROM lots WHERE date_peremption BETWEEN '2026-06-19' AND DATE_ADD('2026-06-19', INTERVAL 30 DAY) AND statut != 'EXPIRED'");
        $stats = $statsStmt->fetch();

        $query = "SELECT l.id, l.medicament_id, l.numero_lot, l.quantite, l.date_peremption, l.statut, m.nom AS medicament_name 
                  FROM lots l 
                  JOIN medicaments m ON l.medicament_id = m.id";

        if ($criteria === 'critical') {
            $query .= " WHERE l.date_peremption <= DATE_ADD('2026-06-19', INTERVAL 30 DAY) AND l.statut != 'EXPIRED'";
        }
        $query .= " ORDER BY l.date_peremption ASC";

        $stmt = $db->query($query);
        return [
            'stats' => ['périssent_le_mois_prochain' => $stats->total ?? 0],
            'batches' => $stmt->fetchAll()
        ];
    }

    public function createLot(array $data): bool {
        $db = Database::getConnection();
        
        $statut = 'ACTIF';
        if (intval($data['quantite']) <= 0) {
            $statut = 'EXHAUSTED';
        } elseif ($data['date_peremption'] < '2026-06-19') {
            $statut = 'EXPIRED';
        }

        $stmt = $db->prepare("INSERT INTO lots (medicament_id, numero_lot, quantite, date_peremption, statut) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['medicament_id'],
            $data['numero_lot'],
            $data['quantite'],
            $data['date_peremption'],
            $statut
        ]);
    }
}