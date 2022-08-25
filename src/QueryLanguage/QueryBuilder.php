<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use ReflectionException;
use Tyutnev\SavannaOrm\EntityCollection;
use Tyutnev\SavannaOrm\EntityFramework;
use Tyutnev\SavannaOrm\EntityFrameworkFactory;
use Tyutnev\SavannaOrm\Exception\EntityFrameworkException;
use Tyutnev\SavannaOrm\QueryLanguage\Command\GroupByCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\HavingCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\JoinCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\LimitCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\OrderByCommand;
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

    public function sum(string $column): float
    {
        $this->select([sprintf('SUM(%s)', $column)]);

        return $this->scalar();
    }

    public function avg(string $column): float
    {
        $this->select([sprintf('AVG(%s)', $column)]);

        return $this->scalar();
    }

    public function min(string $column): float
    {
        $this->select([sprintf('MIN(%s)', $column)]);

        return $this->scalar();
    }

    public function max(string $column): float
    {
        $this->select([sprintf('MAX(%s)', $column)]);

        return $this->scalar();
    }

    public function count(string $column): int
    {
        $this->select([sprintf('COUNT(%s)', $column)]);

        return $this->scalar();
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
        $joinCommand = $this
            ->buildJoin($targetEntity, $alias, $on)
            ->setType('INNER');

        $this->query->addJoin($joinCommand);

        return $this;
    }

    public function leftJoin(string $targetEntity, string $alias, string $on): self
    {
        $joinCommand = $this
            ->buildJoin($targetEntity, $alias, $on)
            ->setType('LEFT');

        $this->query->addJoin($joinCommand);

        return $this;
    }

    public function rightJoin(string $targetEntity, string $alias, string $on): self
    {
        $joinCommand = $this
            ->buildJoin($targetEntity, $alias, $on)
            ->setType('RIGHT');

        $this->query->addJoin($joinCommand);

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

    public function groupBy(string $column): self
    {
        $groupByCommand = (new GroupByCommand())
            ->setColumn($column);

        $this->query->setGroupBy($groupByCommand);

        return $this;
    }

    public function having(string $condition): self
    {
        $havingCommand = (new HavingCommand())
            ->setCondition($condition);

        $this->query->addHaving($havingCommand);

        return $this;
    }

    public function andHaving(string $condition): self
    {
        $havingCommand = (new HavingCommand())
            ->setPrefix('AND')
            ->setCondition($condition);

        $this->query->addHaving($havingCommand);

        return $this;
    }

    public function orHaving(string $condition): self
    {
        $havingCommand = (new HavingCommand())
            ->setPrefix('OR')
            ->setCondition($condition);

        $this->query->addHaving($havingCommand);

        return $this;
    }

    /**
     * Examples:
     *      Entity: App\Entity\User
     *
     *      Query: $userRepository->createQueryBuilder('u')->orderBy('id', 'ASC');
     *      SAVQL: SELECT u.* FROM App\Entity\User AS u ORDER BY u.id ASC
     *
     * @return $this
     */
    public function orderBy(string $column, string $type): self
    {
        $orderByCommand = (new OrderByCommand())
            ->setColumn($column)
            ->setType($type);

        $this->query->setOrderBy($orderByCommand);

        return $this;
    }

    public function limit(int $limit): self
    {
        $limitCommand = (new LimitCommand())
            ->setLimit($limit);

        $this->query->setLimit($limitCommand);

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function fetch(): EntityCollection
    {
        return $this->entityFramework->fetch($this->query, [], $this->targetEntity);
    }

    public function scalar(): mixed
    {
        return $this->entityFramework->scalar($this->query, $this->targetEntity);
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

    private function buildJoin(string $targetEntity, string $alias, string $on): JoinCommand
    {
        return (new JoinCommand())
            ->setTargetEntity($targetEntity)
            ->setAlias($alias)
            ->setOn($on);
    }
}