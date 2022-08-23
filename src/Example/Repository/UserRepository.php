<?php

namespace Tyutnev\SavannaOrm\Example\Repository;

use ReflectionException;
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
     * @throws ReflectionException
     */
    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->fetch();
    }

    /**
     * @throws EntityFrameworkException
     * @throws ReflectionException
     */
    public function getByEmail(string $email): array
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
    public function getByNameAndEmail(string $name, string $email): array
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
    public function getByNameOrEmail(string $name, string $email): array
    {
        return $this
            ->createQueryBuilder('u')
            ->select()
            ->orWhere('u.name', '=', $name)
            ->orWhere('u.email', '=', $email)
            ->fetch();
    }
}