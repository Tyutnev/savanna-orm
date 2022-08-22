<?php

namespace Tyutnev\SavannaOrm\Example\Repository;

use Tyutnev\SavannaOrm\BaseRepository;
use Tyutnev\SavannaOrm\Example\Entity\User;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @throws EntityFrameworkException
     */
    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->fetch();
    }
}