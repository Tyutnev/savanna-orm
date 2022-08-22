<?php

namespace Tyutnev\SavannaOrm;

use Tyutnev\SavannaOrm\Type\ConnectionContextInterface;
use Tyutnev\SavannaOrm\Type\ConnectionEntryInterface;
use Tyutnev\SavannaOrm\Type\LexicalConverterInterface;

class TypeProvider
{
    private ConnectionEntryInterface   $connectionEntry;
    private ConnectionContextInterface $connectionContext;
    private LexicalConverterInterface  $lexicalConverter;

    public function getConnectionEntry(): ConnectionEntryInterface
    {
        return $this->connectionEntry;
    }

    public function setConnectionEntry(ConnectionEntryInterface $connectionEntry): self
    {
        $this->connectionEntry = $connectionEntry;

        return $this;
    }

    public function getConnectionContext(): ConnectionContextInterface
    {
        return $this->connectionContext;
    }

    public function setConnectionContext(ConnectionContextInterface $connectionContext): self
    {
        $this->connectionContext = $connectionContext;

        return $this;
    }

    public function getLexicalConverter(): LexicalConverterInterface
    {
        return $this->lexicalConverter;
    }

    public function setLexicalConverter(LexicalConverterInterface $lexicalConverter): self
    {
        $this->lexicalConverter = $lexicalConverter;

        return $this;
    }
}