<?php

namespace Core;

use PDO;

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        // Obtém a instância única da conexão PDO
        $this->db = Database::getInstance();
    }
}
