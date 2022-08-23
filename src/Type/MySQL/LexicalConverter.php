<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

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

        foreach ($query->getConditions() as $condition) {
            $sql .= $this->handleCondition($condition);
        }

        return trim($sql);
    }

    private function handleSelect(SelectCommand $select): string
    {
        $fromData = explode('\\', $select->getFrom());
        $from     = strtolower($fromData[count($fromData) - 1]);

        return sprintf(
            'SELECT %s FROM %s AS %s',
            $select->getSelection(),
            $from,
            $select->getAlias()
        ) . ' ';
    }

    private function handleCondition(WhereCommand $whereCommand): string
    {
        if ($whereCommand->getPrefix()) {
            return sprintf(
                '%s %s %s %s',
                $whereCommand->getPrefix(),
                $whereCommand->getColumn(),
                $whereCommand->getOperator(),
                $whereCommand->getValue()
            );
        }

        return sprintf(
            'WHERE %s %s %s',
            $whereCommand->getColumn(),
            $whereCommand->getOperator(),
            $whereCommand->getValue()
        );
    }
}