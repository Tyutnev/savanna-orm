<?php

namespace Tyutnev\SavannaOrm;

use CaseConverter\CaseString;
use ReflectionClass;
use ReflectionException;

class EntityFactory
{
    /**
     * @throws ReflectionException
     */
    public function factory(array $item, string $targetEntity): object
    {
        $entity = new $targetEntity;
        $reflectionClass = new ReflectionClass($targetEntity);

        if (!$reflectionClass->getParentClass() || $reflectionClass->getParentClass()->getName() !== BaseEntity::class) {
            throw new ReflectionException(
                sprintf('Entity must be extends by %s', BaseEntity::class)
            );
        }

        foreach ($item as $propertyName => $value) {
            $reflectionClass
                ->getProperty(CaseString::snake($propertyName)->camel())
                ->setValue($entity, $value);
        }

        return $entity;
    }

    /**
     * @throws ReflectionException
     */
    public function factoryFromArray(array $data, string $targetEntity): EntityCollection
    {
        $entities = array_map(function (array $item) use ($targetEntity) {
            return $this->factory($item, $targetEntity);
        }, $data);

        return new EntityCollection($entities);
    }
}