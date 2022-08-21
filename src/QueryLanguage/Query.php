<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

class Query
{
    private string $select = '';
    private string $join = '';
    private string $condition = '';
    private string $groupBy = '';
    private string $having = '';
    private string $orderBy = '';
    private string $limit = '';

    public function getSelect(): string
    {
        return $this->select;
    }

    public function setSelect(string $select): self
    {
        $this->select = $select;

        return $this;
    }

    public function getJoin(): string
    {
        return $this->join;
    }

    public function setJoin(string $join): self
    {
        $this->join = $join;

        return $this;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function setCondition(string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function getGroupBy(): string
    {
        return $this->groupBy;
    }

    public function setGroupBy(string $groupBy): self
    {
        $this->groupBy = $groupBy;

        return $this;
    }

    public function getHaving(): string
    {
        return $this->having;
    }

    public function setHaving(string $having): self
    {
        $this->having = $having;

        return $this;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getLimit(): string
    {
        return $this->limit;
    }

    public function setLimit(string $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}