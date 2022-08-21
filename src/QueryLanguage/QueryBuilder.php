<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

use Tyutnev\SavannaOrm\QueryLanguage\Command\SelectCommand;

class QueryBuilder
{
    private Query  $query;
    private string $alias;
    private string $targetEntity;

    public function __construct(string $alias, string $targetEntity)
    {
        $this->query        = new Query();
        $this->alias        = $alias;
        $this->targetEntity = $targetEntity;
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
     * @param string[] $selection
     * @return $this
     */
    public function select(array $selection): self
    {
        $selectCommand = new SelectCommand();

        $selectCommand
            ->setSelection(empty($selection) ? sprintf('%.*', $this->alias) : implode(', ', $selection))
            ->setFrom($this->targetEntity)
            ->setAlias($this->alias);

        $this->query->setSelect($selectCommand);

        return $this;
    }
}