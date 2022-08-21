<?php

namespace Tyutnev\SavannaOrm\Type;

interface ConnectionFactoryInterface
{
    public function factory(): ConnectionEntryInterface;
}