<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

use PDO;
use Tyutnev\SavannaOrm\Type\ConnectionEntryInterface;

class ConnectionEntry implements ConnectionEntryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function get(): PDO
    {
        return $this->pdo;
    }
}