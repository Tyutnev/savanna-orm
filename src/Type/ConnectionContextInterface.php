<?php

namespace Tyutnev\SavannaOrm\Type;

interface ConnectionContextInterface
{
    public function fetch(ConnectionEntryInterface $connectionEntry, string $query, array $params): array;
    public function one(ConnectionEntryInterface $connectionEntry, string $query, array $params): array;
    public function scalar(ConnectionEntryInterface $connectionEntry, string $query): mixed;
}