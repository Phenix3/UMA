<?php

declare(strict_types=1);

namespace App\Domain\Slider\Repository;

use App\Domain\Slider\Entity\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Slider>
 *
 * @method null|Slider find($id, $lockMode = null, $lockVersion = null)
 * @method null|Slider findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    public function save(Slider $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Slider $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWithItems(mixed $id): ?object
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.items', 'items')
            ->addSelect('items')
            ->where('s.id = :id')
            ->setParameter('id', Uuid::fromString($id)->toBinary())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findWithItemsBy(array $criterias): ?object
    {
        $q = $this->createQueryBuilder('s')
            ->leftJoin('s.items', 'items')
            ->addSelect('items')
        ;

        foreach ($criterias as $k => $v) {
            $q = $q->andWhere("s.{$k} = :{$k}")
                ->setParameter("{$k}", $v)
            ;
        }

        return $q->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
