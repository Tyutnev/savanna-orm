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

    /**
     * @throws ReflectionException
     */
    public function one(Query $savqlQuery, array $params, string $targetEntity): ?object
    {
        $connectionEntry   = $this->typeProvider->getConnectionEntry();
        $connectionContext = $this->typeProvider->getConnectionContext();
        $lexicalConverter  = $this->typeProvider->getLexicalConverter();

        $query = $lexicalConverter->convert($savqlQuery);

        return $this->entityFactory->factory(
            $connectionContext->one($connectionEntry, $query, $params), $targetEntity
        );
    }

    public function scalar(Query $savqlQuery, string $targetEntity): mixed
    {
        $connectionEntry   = $this->typeProvider->getConnectionEntry();
        $connectionContext = $this->typeProvider->getConnectionContext();
        $lexicalConverter  = $this->typeProvider->getLexicalConverter();

        $query = $lexicalConverter->convert($savqlQuery);

        return $connectionContext->scalar($connectionEntry, $query);
    }
}