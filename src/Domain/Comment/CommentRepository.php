<?php

namespace App\Domain\Comment;

use App\Domain\Auth\Entity\User;
use App\Infrastructure\ORM\AbstractRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

/**
 * @extends AbstractRepository<Comment>
 */
class CommentRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * Récupère les commentaires pour le listing de l'API en évitant la liaison content.
     *
     * @return array<Comment>
     */
    public function findForApi(mixed $content): array
    {
        // dd(Uuid::fromRfc4122($content));
        // Force l'enregistrement de l'entité dans l'entity manager pour éviter les requêtes supplémentaires
        $this->_em->getReference(\App\Domain\Blog\Entity\Post::class, Uuid::fromRfc4122($content));

        return $this->createQueryBuilder('c')
            ->select('c, u')
            ->orderBy('c.createdAt', 'ASC')
            ->where('c.target = :content')
            ->leftJoin('c.author', 'u')
            ->setParameter('content', Uuid::fromString($content)->toBinary())
            ->getQuery()
            ->getResult();
    }

    /**
     * Renvoie un commentaire en évitant la liaison content.
     */
    public function findPartial(int $id): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->select('partial c.{id, username, email, content, createdAt}, partial u.{id, username, email}')
            ->where('c.id = :id')
            ->leftJoin('c.author', 'u')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getOneOrNullResult();
    }

    public function queryLatest(): Query
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->join('c.target', 't')
            ->leftJoin('c.author', 'a')
            ->addSelect('t', 'a')
            ->setMaxResults(7)
            ->getQuery();
    }

    public function findLastByUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.author = :user')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(4)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
