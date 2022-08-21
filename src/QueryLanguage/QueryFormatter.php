<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

class QueryFormatter
{
    public function format(Query $query): string
    {
        $savannaQueryLanguage = '';

        if ($query->getSelect()) {
            $savannaQueryLanguage .= sprintf(
                'SELECT %s FROM %s AS %s',
                $query->getSelect()->getSelection(),
                $query->getSelect()->getFrom(),
                $query->getSelect()->getAlias()
            ) . ' ';
        }

        return trim($savannaQueryLanguage);
    }
}