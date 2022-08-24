<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use ReflectionException;
use Tyutnev\SavannaOrm\EntityCollection;
use Tyutnev\SavannaOrm\EntityFramework;
use Tyutnev\SavannaOrm\EntityFrameworkFactory;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;
use Tyutnev\SavannaOrm\QueryLanguage\Command\JoinCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\WhereCommand;

class QueryBuilder
{
    private Query           $query;
    private QueryFormatter  $queryFormatter;
    private EntityFramework $entityFramework;
    private string          $alias;
    private string          $targetEntity;

    /**
     * @throws EntityFrameworkException
     */
    public function __construct(string $alias, string $targetEntity)
    {
        $this->query           = new Query();
        $this->queryFormatter  = new QueryFormatter();
        $this->entityFramework = (new EntityFrameworkFactory())->factory();
        $this->alias           = $alias;
        $this->targetEntity    = $targetEntity;

        $selectCommand = new SelectCommand();

        $selectCommand
            ->setSelection(sprintf('%s.*', $this->alias))
            ->setFrom($this->targetEntity)
            ->setAlias($this->alias);

        $this->query->setSelect($selectCommand);
    }

    /**
     * Examples:
     *      Entity: App\Entity\User
     *
     *      Query: $userRepository->createQueryBuilder('u')->select()
     *      SAVQL: SELECT u.* FROM App\Entity\User AS u
     *
     *      Query: $userRepository->createQueryBuilder('u')->select(['u.name', 'u.email', 'u.password'])
     *      SAVQL: SELECT u.name, u.email, u.password FROM App\Entity\User as u
     *
     * @param string[] $selection
     * @return $this
     */
    public function select(array $selection = []): self
    {
        $selectCommand = new SelectCommand();

        $selectCommand
            ->setSelection(empty($selection) ? sprintf('%s.*', $this->alias) : implode(', ', $selection))
            ->setFrom($this->targetEntity)
            ->setAlias($this->alias);

        $this->query->setSelect($selectCommand);

        return $this;
    }

    /**
     * Examples:
     *      Entity: App\Entity\User
     *
     *      Query: $userRepository->createQueryBuilder('u')->select()->where('u.id', '=', 1)
     *      SAVQL: SELECT u.* FROM App\Entity\User AS u WHERE u.id = 1
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return $this
     */
    public function where(string $column, string $operator, mixed $value): self
    {
        $whereCommand = $this->buildCondition($column, $operator, $value);

        $this->query->addCondition($whereCommand);

        return $this;
    }

    public function andWhere(string $column, string $operator, mixed $value): self
    {
        $whereCommand = $this->buildCondition($column, $operator, $value);
        $whereCommand->setPrefix('AND');

        $this->query->addCondition($whereCommand);

        return $this;
    }

    public function orWhere(string $column, string $operator, mixed $value): self
    {
        $whereCommand = $this->buildCondition($column, $operator, $value);
        $whereCommand->setPrefix('OR');

        $this->query->addCondition($whereCommand);

        return $this;
    }

    /**
     * Examples:
     *      Entity: App\Entity\User
     *
     *      Query: $userRepository->createQueryBuilder('u')->innerJoin(Product::class, 'p', 'u.id = p.user_id')
     *      SAVQL: SELECT u.* FROM App\Entity\User AS u INNER JOIN App\Entity\Product AS p ON u.id = p.user_id
     *
     * @return $this
     */
    public function innerJoin(string $targetEntity, string $alias, string $on): self
    {
        $joinCommand = (new JoinCommand())
            ->setType('INNER')
            ->setTargetEntity($targetEntity)
            ->setAlias($alias)
            ->setOn($on);

        $this->query->addJoin($joinCommand);

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function fetch(): EntityCollection
    {
        return $this->entityFramework->fetch($this->query, [], $this->targetEntity);
    }

    public function getQuery(): Query
    {
        return $this->query;
    }

    public function getSAVQL(): string
    {
        return $this->queryFormatter->format($this->query);
    }

    private function buildCondition(string $column, string $operator, mixed $value): WhereCommand
    {
        return (new WhereCommand())
            ->setColumn($column)
            ->setOperator($operator)
            ->setValue($value);
    }
}