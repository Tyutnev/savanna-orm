<?php

namespace Tyutnev\SavannaOrm\Example\Entity;

use Tyutnev\SavannaOrm\BaseEntity;

class Transaction extends BaseEntity
{
    private int   $id;
    private float $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}