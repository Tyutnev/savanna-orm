<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;

class QueryBuilder
{
    private Query $query;

    public function __construct()
    {
        $this->query = new Query();
    }

    /**
     * Examples:
     *      Entity: App\Entity\User
     *
     *      Query: $userRepository->createQueryBuilder('u')->select()
     *      SAVQL: SELECT u.* FROM App\Entity\User AS u
     *
     *      Query: $userRepository->createQueryBuilder('u')->select(['u.name', 'u.email', 'u.password'])
     *      SAVQL: SELECT u.name, u.email, u.password FROM App\Entity\User as u
     *
     * @param string   $alias
     * @param string[] $selection
     * @param string   $from
     * @return $this
     */
    public function select(string $alias, array $selection, string $from): self
    {
        $selectCommand = new SelectCommand();

        $selectCommand
            ->setSelection(empty($selection) ? sprintf('%.*', $alias) : implode(', ', $selection))
            ->setFrom($from)
            ->setAlias($alias);

        $this->query->setSelect($selectCommand);

        return $this;
    }
}