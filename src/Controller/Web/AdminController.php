<?php
namespace App\Controller\Web;

use App\Service\AuthService;
use App\Config\Database;

class AdminController{
    private AuthService $authService;

    public function __construct(){
        $this->authService = new AuthService();
    }

    public function showReports(): void{
        $this->authService->checkRoleOrRedirect('ADMIN');
        $db = Database::getConnection();

        $stmt = $db->query("SELECT SUM(quantity * 15) as perte_totale 
        FROM batches
        WHERE status = 'EXPIRED'");
        $data = $stmt->fetch();
        $perte = $data['perte_totale'] ?? 0;
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Rapport Financier des Pertes</title>
            <link rel='stylesheet' href='/css/style.css'>
        </head>
        <body>
            <div style='padding: 30px; font-family: sans-serif;'>
                <h2>🛡️ Zone Admin : Rapport Financier des Pertes</h2>
                <hr>
                <div style='background: #fee2e2; padding: 20px; border-radius: 8px; color: #991b1b; font-size: 20px;'>
                    Coût total des pertes (Produits Périmés) : <strong>$perte.00 DH</strong>
                </div>
                <p><a href='/'>Retour au Dashboard</a></p>
            </div>
        </body>
        </html>";
    }
}