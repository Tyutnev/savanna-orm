<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;

class Query
{
    private ?SelectCommand $select = null;

    public function getSelect(): ?SelectCommand
    {
        return $this->select;
    }

    public function setSelect(SelectCommand $select): self
    {
        $this->select = $select;

        return $this;
    }
}