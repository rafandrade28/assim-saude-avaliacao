<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    // Construtor privado para impedir instanciamento direto (Singleton)
    private function __construct() {}
    
    // Evita clonagem do objeto
    private function __clone() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../app/config.php';
            
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
            } catch (PDOException $e) {
                // Tratamento básico: interrompe a execução e exibe o erro
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
