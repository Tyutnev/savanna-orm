<?php

namespace Tyutnev\SavannaOrm\QueryLanguage;

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
        $savql = '';

        if (empty($selection)) {
            $savql .= sprintf('SELECT %s.* FROM %s AS %s1', $alias, $from);
        } else {
            $savql .= sprintf(
                'SELECT %s FROM %s AS %s',
                implode(', ', $selection),
                $from,
                $alias
            );
        }

        $this->query->setSelect($savql);

        return $this;
    }
}