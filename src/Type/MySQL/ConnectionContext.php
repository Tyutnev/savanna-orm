<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

use PDO;
use Tyutnev\SavannaOrm\Type\ConnectionContextInterface;
use Tyutnev\SavannaOrm\Type\ConnectionEntryInterface;

class ConnectionContext implements ConnectionContextInterface
{
    public function fetch(ConnectionEntryInterface $connectionEntry, string $query, array $params): array
    {
        /** @var PDO $pdo */
        $pdo = $connectionEntry->get();

        $statement = $pdo->prepare($query);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}