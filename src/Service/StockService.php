<?php
namespace App\Service;

use App\Config\Database;
use PDO;

class StockService{
    private PDO $db;

    public function __construct(){
        $this->db = Database::getConnection();
    }
}