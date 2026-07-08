<?php

namespace Core;

class Database
{
    private \PDO $connection;

    public function __construct()
    {
        // TODO: Implementar conexão com o banco de dados futuramente
    }

    public function query(string $sql, array $params = []): void
    {
        // TODO: Implementar execução de queries futuramente
    }
}
