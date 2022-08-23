<?php

namespace Tyutnev\SavannaOrm\Example\Repository;

use ReflectionException;
use Tyutnev\SavannaOrm\BaseRepository;
use Tyutnev\SavannaOrm\EntityCollection;
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
     * @throws ReflectionException
     */
    public function getAll(): EntityCollection
    {
        return $this
            ->createQueryBuilder('u')
            ->fetch();
    }

    /**
     * @throws EntityFrameworkException
     * @throws ReflectionException
     */
    public function getByEmail(string $email): EntityCollection
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->where('u.email', '=', $email)
            ->fetch();
    }

    /**
     * @throws EntityFrameworkException
     * @throws ReflectionException
     */
    public function getByNameAndEmail(string $name, string $email): EntityCollection
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->andWhere('u.name', '=', $name)
            ->andWhere('u.email', '=', $email)
            ->fetch();
    }

    /**
     * @throws EntityFrameworkException
     * @throws ReflectionException
     */
    public function getByNameOrEmail(string $name, string $email): EntityCollection
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->orWhere('u.name', '=', $name)
            ->orWhere('u.email', '=', $email)
            ->fetch();
    }
}