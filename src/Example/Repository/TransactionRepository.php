<?php

namespace Tyutnev\SavannaOrm\Example\Repository;

use Tyutnev\SavannaOrm\BaseRepository;
use Tyutnev\SavannaOrm\Example\Entity\Transaction;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;

class TransactionRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Transaction::class);
    }

    /**
     * @throws EntityFrameworkException
     */
    public function getSumValue(): float
    {
        return $this->createQueryBuilder('t')
            ->sum('t.value');
    }
}