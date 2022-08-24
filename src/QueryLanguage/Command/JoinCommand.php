<?php

namespace Tyutnev\SavannaOrm\QueryLanguage\Command;

class JoinCommand
{
    private string $type;
    private string $targetEntity;
    private string $alias;
    private string $on;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTargetEntity(): string
    {
        return $this->targetEntity;
    }

    public function setTargetEntity(string $targetEntity): self
    {
        $this->targetEntity = $targetEntity;

        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getOn(): string
    {
        return $this->on;
    }

    public function setOn(string $on): self
    {
        $this->on = $on;

        return $this;
    }
}