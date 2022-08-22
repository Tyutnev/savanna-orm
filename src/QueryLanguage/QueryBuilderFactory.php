<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;

class QueryBuilderFactory
{
    /**
     * @throws EntityFrameworkException
     */
    public function createQueryBuilder(string $alias, string $targetEntity): QueryBuilder
    {
        return new QueryBuilder($alias, $targetEntity);
    }
}