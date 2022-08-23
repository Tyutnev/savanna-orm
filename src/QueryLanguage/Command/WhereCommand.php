<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class WhereCommand
{
    private string  $column;
    private string  $operator;
    private mixed   $value;
    private ?string $prefix = null;

    public function getColumn(): string
    {
        return $this->column;
    }

    public function setColumn(string $column): self
    {
        $this->column = $column;

        return $this;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }
}