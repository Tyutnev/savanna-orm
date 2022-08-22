<?php

namespace Tyutnev\SavannaOrm\Type;

interface ConnectionContextInterface
{
    public function fetch(ConnectionEntryInterface $connectionEntry, string $query, array $params): array;
}