<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class HavingCommand
{
    private string $type = '';
    private string $condition;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
}