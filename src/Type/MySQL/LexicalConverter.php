<?php

namespace Tyutnev\SavannaOrm\Type\MySQL;

use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;
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
}