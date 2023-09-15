<?php

declare(strict_types=1);

namespace App\Domain\Auth\Repository;

use App\Domain\Auth\Entity\User;
use App\Infrastructure\ORM\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactRequest>
 *
 * @method null|ContactRequest find($id, $lockMode = null, $lockVersion = null)
 * @method null|ContactRequest findOneBy(array $criteria, array $orderBy = null)
 * @method ContactRequest[]    findAll()
 * @method ContactRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
