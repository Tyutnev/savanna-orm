<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class HavingCommand
{
    private ?string $prefix = null;
    private string  $condition;

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

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