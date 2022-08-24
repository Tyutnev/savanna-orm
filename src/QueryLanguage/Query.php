<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\QueryLanguage\Command\JoinCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\OrderByCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\WhereCommand;

class Query
{
    private ?SelectCommand  $select     = null;
    /** @var JoinCommand[] */
    private array           $joins      = [];
    /** @var WhereCommand[] */
    private array           $conditions = [];
    private ?OrderByCommand $orderBy    = null;

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

    public function getOrderBy(): ?OrderByCommand
    {
        return $this->orderBy;
    }

    public function setOrderBy(?OrderByCommand $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }
}