<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Infrastructure\ORM\AbstractRepository;
use App\Infrastructure\ORM\IterableQueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, ?bool $flush = false)
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, ?bool $flush = false)
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRecent(int $limit): IterableQueryBuilder
    {
        return $this->createIterableQuery('p')
            ->select('p')
            ->where('p.createdAt < NOW()')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit);
    }

    public function queryAll(Category $category = null): Query
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.createdAt < NOW()')
            ->orderBy('p.createdAt', 'DESC')
        ;
        if ($category) {
            $query = $query->andWhere('p.categories IN (:categories)')
                ->setParameter('categories', [$category]);
        }

        return $query->getQuery();
    }
}
