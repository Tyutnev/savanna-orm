<?php

namespace Tyutnev\SavannaOrm;

use Tyutnev\SavannaOrm\QueryLanguage\Query;

class EntityFramework
{
    private TypeProvider $typeProvider;

    public function __construct(TypeProvider $typeProvider)
    {
        $this->typeProvider = $typeProvider;
    }

    public function fetch(Query $savqlQuery, array $params): array
    {
        $connectionEntry   = $this->typeProvider->getConnectionEntry();
        $connectionContext = $this->typeProvider->getConnectionContext();
        $lexicalConverter  = $this->typeProvider->getLexicalConverter();

        $query = $lexicalConverter->convert($savqlQuery);

        return $connectionContext->fetch($connectionEntry, $query, $params);
    }
}