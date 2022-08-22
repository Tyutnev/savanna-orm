<?php

namespace Tyutnev\SavannaOrm;

use Tyutnev\SavannaOrm\QueryLanguage\QueryBuilder;
use Tyutnev\SavannaOrm\QueryLanguage\QueryBuilderFactory;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;

class BaseRepository
{
    private QueryBuilderFactory $queryBuilderFactory;
    private string              $targetEntity;

    public function __construct(string $targetEntity)
    {
        $this->queryBuilderFactory = new QueryBuilderFactory();
        $this->targetEntity        = $targetEntity;
    }

    /**
     * @throws EntityFrameworkException
     */
    public function createQueryBuilder(string $alias): QueryBuilder
    {
        return $this->queryBuilderFactory->createQueryBuilder($alias, $this->targetEntity);
    }
}