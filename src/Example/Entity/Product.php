<?php

namespace Tyutnev\SavannaOrm\Example\Entity;

use Tyutnev\SavannaOrm\BaseEntity;

class Product extends BaseEntity
{
    private int    $id;
    private string $name;
    private int    $userId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}