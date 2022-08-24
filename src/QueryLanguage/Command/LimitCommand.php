<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class LimitCommand
{
    private int $limit;

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}