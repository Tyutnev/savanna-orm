<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

use Tyutnev\SavannaOrm\QueryLanguage\Command\JoinCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\LimitCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\OrderByCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Command\WhereCommand;
use Tyutnev\SavannaOrm\QueryLanguage\Query;
use Tyutnev\SavannaOrm\Type\LexicalConverterInterface;

class LexicalConverter implements LexicalConverterInterface
{
    public function convert(Query $query): string
    {
        $sql = '';

        if ($query->getSelect()) {
            $sql .= $this->handleSelect($query->getSelect());
        }

        foreach ($query->getJoins() as $join) {
            $sql .= $this->handleJoin($join);
        }

        foreach ($query->getConditions() as $index => $condition) {
            if ($index === 0 && $condition->getPrefix()) {
                $condition->setPrefix(null);
            }

            $sql .= $this->handleCondition($condition);
        }

        if ($query->getOrderBy()) {
            $sql .= $this->handleOrderBy($query->getOrderBy());
        }

        if ($query->getLimit()) {
            $sql .= $this->handleLimit($query->getLimit());
        }

        return trim($sql);
    }

    private function handleSelect(SelectCommand $select): string
    {
        $fromData = explode('\\', $select->getFrom());
        $from     = strtolower($fromData[count($fromData) - 1]);

        return sprintf(
            'SELECT %s FROM %s AS %s ',
            $select->getSelection(),
            $from,
            $select->getAlias()
        );
    }

    private function handleJoin(JoinCommand $joinCommand): string
    {
        $targetTable = explode('\\', $joinCommand->getTargetEntity());
        $targetTable = strtolower($targetTable[count($targetTable) - 1]);

        return sprintf(
            '%s JOIN %s AS %s ON %s ',
            $joinCommand->getType(),
            $targetTable,
            $joinCommand->getAlias(),
            $joinCommand->getOn()
        );
    }

    private function handleCondition(WhereCommand $whereCommand): string
    {
        if ($whereCommand->getPrefix()) {
            return sprintf(
                " %s %s %s '%s'",
                $whereCommand->getPrefix(),
                $whereCommand->getColumn(),
                $whereCommand->getOperator(),
                $whereCommand->getValue()
            );
        }

        return sprintf(
            "WHERE %s %s '%s' ",
            $whereCommand->getColumn(),
            $whereCommand->getOperator(),
            $whereCommand->getValue()
        );
    }

    private function handleOrderBy(OrderByCommand $orderByCommand): string
    {
        return sprintf(
            'ORDER BY %s %s ',
            $orderByCommand->getColumn(),
            $orderByCommand->getType()
        );
    }

    private function handleLimit(LimitCommand $limitCommand): string
    {
        return sprintf(
            'LIMIT %d',
            $limitCommand->getLimit()
        );
    }
}