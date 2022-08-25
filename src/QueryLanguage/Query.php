<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\QueryLanguage\Command\GroupByCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\HavingCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\JoinCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\LimitCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\OrderByCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\WhereCommand;

class Query
{
    private ?SelectCommand  $select         = null;
    /** @var JoinCommand[] */
    private array           $joins          = [];
    /** @var WhereCommand[] */
    private array           $conditions     = [];
    private ?GroupByCommand $groupBy        = null;
    /** @var HavingCommand[]  */
    private array           $having         = [];
    private ?OrderByCommand $orderBy        = null;
    private ?LimitCommand   $limit          = null;

    public function getSelect(): ?SelectCommand
    {
        return $this->select;
    }

    public function setSelect(SelectCommand $select): self
    {
        $this->select = $select;

        return $this;
    }

    /**
     * @return JoinCommand[]
     */
    public function getJoins(): array
    {
        return $this->joins;
    }

    public function addJoin(JoinCommand $join): self
    {
        $this->joins[] = $join;

        return $this;
    }

    /**
     * @return WhereCommand[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param WhereCommand $condition
     * @return $this
     */
    public function addCondition(WhereCommand $condition): self
    {
        $this->conditions[] = $condition;

        return $this;
    }

    public function getGroupBy(): ?GroupByCommand
    {
        return $this->groupBy;
    }

    public function setGroupBy(?GroupByCommand $groupBy): self
    {
        $this->groupBy = $groupBy;

        return $this;
    }

    public function getHaving(): array
    {
        return $this->having;
    }

    public function addHaving(HavingCommand $havingCommand): self
    {
        $this->having[] = $havingCommand;

        return $this;
    }

    public function getOrderBy(): ?OrderByCommand
    {
        return $this->orderBy;
    }

    public function setOrderBy(?OrderByCommand $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getLimit(): ?LimitCommand
    {
        return $this->limit;
    }

    public function setLimit(?LimitCommand $limitCommand): self
    {
        $this->limit = $limitCommand;

        return $this;
    }
}