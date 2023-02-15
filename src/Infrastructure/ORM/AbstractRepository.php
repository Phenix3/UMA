<?php

namespace App\Infrastructure\ORM;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function findOrFail(int|string $id): object
    {
        $entity = $this->find($id, null, null);
        if (null === $entity) {
            throw EntityNotFoundException::fromClassNameAndIdentifier($this->_entityName, [(string) $id]);
        }
        return $entity;
    }

    public function findByCaseInsensitive(array $conditions): array
    {
        return $this->findByCaseInsensitiveQuery($conditions)->getResult();
    }

    public function findOneByCaseInsensitive(array $conditions): object
    {
        return $this->findByCaseInsensitiveQuery($conditions)->setMaxResults(1)->getOneOrNullResult();
    }

    public function createIterableQuery(string $alias, $indexBy = null): IterableQueryBuilder
    {
        $queryBuilder = new IterableQueryBuilder($this->_em);
        return $queryBuilder->select($alias)->from($this->_entityName, $alias, $indexBy);
    }

    public function findByCaseInsensitiveQuery(array $conditions): Query
    {
        $conditionString = [];
        $parameters = [];
        foreach ($conditions as $key => $value) {
            $conditionString[] = "LOWER(o.{$key}) = :{$key}";
            $parameters[$key] = mb_strtolower($value);
        }

        return $this->createQueryBuilder('o')
            ->andWhere(join(' AND ', $conditionString))
            ->setParameters($parameters)
            ->getQuery();
    }
}