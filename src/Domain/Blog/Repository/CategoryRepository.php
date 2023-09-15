<?php

declare(strict_types=1);

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Category;
use App\Infrastructure\ORM\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, ?bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, ?bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWithCount(): array
    {
        $data = $this->createQueryBuilder('c')
            ->join('c.posts', 'p')
            ->groupBy('c.id')
            ->select('c', 'COUNT(p.id) as count')
            ->getQuery()
            ->getResult()
        ;

        return array_map(static function (array $d) {
            $d[0]->setPostsCount((int) $d['count']);

            return $d[0];
        }, $data);
    }
}
