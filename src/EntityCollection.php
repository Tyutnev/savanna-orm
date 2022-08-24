<?php

namespace Tyutnev\SavannaOrm;

use ArrayAccess;
use Iterator;

class EntityCollection implements ArrayAccess, Iterator
{
    private array $entities;
    private int   $iteratorPosition = 0;

    public function __construct(array $entities = [])
    {
        $this->entities = $entities;
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function sum(string $column): float
    {
        $result = 0;
        $column = 'get' . ucfirst($column);

        foreach ($this->entities as $entity) {
            $result += $entity->{$column}();
        }

        return $result;
    }

    public function avg(string $column): float
    {
        return $this->sum($column) / $this->count();
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->entities[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->entities[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->entities[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->entities[$offset]);
    }

    public function current(): mixed
    {
        return $this->entities[$this->iteratorPosition];
    }

    public function next(): void
    {
        ++$this->iteratorPosition;
    }

    public function key(): int
    {
        return $this->iteratorPosition;
    }

    public function valid(): bool
    {
        return isset($this->entities[$this->iteratorPosition]);
    }

    public function rewind(): void
    {
        $this->iteratorPosition = 0;
    }
}