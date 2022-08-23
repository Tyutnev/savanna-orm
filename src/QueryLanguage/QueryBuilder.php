<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use ReflectionException;
use Tyutnev\SavannaOrm\EntityFramework;
use Tyutnev\SavannaOrm\EntityFrameworkFactory;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;
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
        $whereCommand = new WhereCommand();

        $whereCommand
            ->setColumn($column)
            ->setOperator($operator)
            ->setValue($value);

        $this->query->addCondition($whereCommand);

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function fetch(): array
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
}