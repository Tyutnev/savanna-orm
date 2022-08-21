<?php

namespace Tyutnev\SavannaOrm\Type;

use Tyutnev\SavannaOrm\QueryLanguage\Query;

interface LexicalConverterInterface
{
    public function convert(Query $query) : string;
}