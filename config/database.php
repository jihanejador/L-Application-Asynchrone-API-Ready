<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO{
        if(self::$instance === null){
            try{
                $host = 'localhost';
                $dbname = 'pharma_fefo';
                $username = 'root';
                $password = '';

                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_EMULATE_PREPARES => FALSE,
                    ]
                );
            } catch (PDOException $e){
                die("Erreur de connexion DB :" . $e->getMessage());
            }
        }
        return self::$instance;
    }
}