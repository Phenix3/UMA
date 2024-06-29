<?php

declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\Auth\Entity\User;
use App\Infrastructure\ORM\AbstractRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends AbstractRepository<Comment>
 */
final class CommentRepository extends AbstractRepository
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
    public function findForApi(mixed $contentId): array
    {
        // Force l'enregistrement de l'entité dans l'entity manager pour éviter les requêtes supplémentaires
        $this->_em->getReference(\App\Domain\Application\Entity\Content::class, Uuid::fromString($contentId));

        return $this->createQueryBuilder('c')
            ->select(
                'partial c.{id, username, email, content, createdAt, parent}',
                'partial u.{id, username, email}',
                't',
                'p'
            )
            ->orderBy('c.createdAt', 'ASC')
            ->where('t = :content')
            ->leftJoin('c.author', 'u')
            ->leftJoin('c.target', 't')
            ->leftJoin('c.parent', 'p')
            ->setParameter('content', Uuid::fromString($contentId)->toBinary())
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getResult()
        ;
    }

    /**
     * Renvoie un commentaire en évitant la liaison content.
     *
     * @param Uuid $id
     */
    public function findPartial($id): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->select('partial c.{id, username, email, content, createdAt}, partial u.{id, username, email}')
            ->where('c.id = :id')
            ->leftJoin('c.author', 'u')
            ->setParameter('id', $id->toBinary())
            ->setMaxResults(1)
            ->getQuery()
            ->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true)
            ->getOneOrNullResult()
        ;
    }

    public function queryLatest(): Query
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->join('c.target', 't')
            ->leftJoin('c.author', 'a')
            ->addSelect('t', 'a')
            ->setMaxResults(7)
            ->getQuery()
        ;
    }

    public function findLastByUser(User $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.author = :user')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(4)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
