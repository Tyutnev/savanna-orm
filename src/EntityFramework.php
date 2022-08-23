<?php

namespace Tyutnev\SavannaOrm;

use ReflectionException;
use Tyutnev\SavannaOrm\QueryLanguage\Query;

class EntityFramework
{
    private TypeProvider  $typeProvider;
    private EntityFactory $entityFactory;

    public function __construct(TypeProvider $typeProvider)
    {
        $this->typeProvider  = $typeProvider;
        $this->entityFactory = new EntityFactory();
    }

    /**
     * @throws ReflectionException
     */
    public function fetch(Query $savqlQuery, array $params, string $targetEntity): EntityCollection
    {
        $connectionEntry   = $this->typeProvider->getConnectionEntry();
        $connectionContext = $this->typeProvider->getConnectionContext();
        $lexicalConverter  = $this->typeProvider->getLexicalConverter();

        $query = $lexicalConverter->convert($savqlQuery);

        return $this->entityFactory->factoryFromArray(
            $connectionContext->fetch($connectionEntry, $query, $params), $targetEntity
        );
    }
}