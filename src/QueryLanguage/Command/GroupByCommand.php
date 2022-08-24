<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class GroupByCommand
{
    private string $column;

    public function getColumn(): string
    {
        return $this->column;
    }

    public function setColumn(string $column): self
    {
        $this->column = $column;

        return $this;
    }
}