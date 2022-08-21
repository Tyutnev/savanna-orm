<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

use PDO;
use PDOException;
use Tyutnev\SavannaOrm\Exception\ConnectionException;
use Tyutnev\SavannaOrm\Type\ConnectionEntryInterface;
use Tyutnev\SavannaOrm\Type\ConnectionFactoryInterface;

class ConnectionFactory implements ConnectionFactoryInterface
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    public function __construct(string $host, string $username, string $password, string $database)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    /**
     * @throws ConnectionException
     */
    public function factory(): ConnectionEntryInterface
    {
        $dsn = sprintf('mysql:dbname=%s;host=%s', $this->database, $this->host);

        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            return new ConnectionEntry($pdo);
        } catch (PDOException $e) {
            throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
        }
    }
}