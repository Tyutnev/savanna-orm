<?php

namespace Tyutnev\SavannaOrm\Example\Repository;

use ReflectionException;
use Tyutnev\SavannaOrm\BaseRepository;
use Tyutnev\SavannaOrm\EntityCollection;
use Tyutnev\SavannaOrm\Example\Entity\Product;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    /**
     * @throws ReflectionException
     * @throws EntityFrameworkException
     */
    public function getAll(): EntityCollection
    {
        return $this
            ->createQueryBuilder('p')
            ->fetch();
    }
}