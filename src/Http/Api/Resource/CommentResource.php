<?php

declare(strict_types=1);

namespace App\Http\Api\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Domain\Auth\Entity\User;
use App\Domain\Comment\Comment;
use App\Http\Api\Processor\CommentProcessor;
use App\Http\Api\Provider\CommentApiProvider;
use App\Validator\NotExists;
// use Parsedown;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

// use Symfony\Component\Uid\Uuid

#[ApiResource(
    provider: CommentApiProvider::class,
    shortName: 'Comment',
    normalizationContext: [
        'group' => ['read'],
    ],
    denormalizationContext: [
        'group' => ['write'],
    ],
    operations: [
        new GetCollection(),
        new Post(processor: CommentProcessor::class),
        new Get(processor: CommentProcessor::class),
        new Delete(
            processor: CommentProcessor::class,
            security: "is_granted('ROLE_ADMIN') or object.userId == user"
        ),
        new Put(
            processor: CommentProcessor::class,
            security: "is_granted('update', object)"
        ),
    ]
)]
final class CommentResource
{
    #[Groups(['read'])]
    #[ApiProperty(identifier: true)]
    public mixed $id = null;

    #[Groups(['read', 'write'])]
    #[Assert\NotBlank(groups: ['anonymous'], normalizer: 'trim')]
    #[NotExists(
        groups: ['anonymous'],
        field: 'username',
        class: User::class,
        message: 'Ce pseudo est utilisé par un utilisateur'
    )
    ]
    public ?string $username = null;

    #[Assert\NotBlank(normalizer: 'trim')]
    #[Groups(['read', 'write'])]
    #[Assert\Length(min: 4, normalizer: 'trim')]
    public string $content = '';

    #[Groups(['read'])]
    public string $html = '';

    #[Groups(['read'])]
    public ?string $avatar = null;

    #[Groups(['write'])]
    public Uuid|string|null $target = null;

    #[Groups(['read'])]
    public int $createdAt = 0;

    #[Groups(['read', 'write'])]
    public Uuid|string|null $parent = null;

    /**
     * Garde une trace de l'entité qui a servi à créer la resource.
     */
    public ?Comment $entity = null;

    #[Groups(['read'])]
    public ?Uuid $userId = null;

    public static function fromComment(Comment $comment, ?UploaderHelper $uploaderHelper = null): self
    {
        $resource = new self();
        $author = $comment->getAuthor();
        $resource->id = $comment->getId();
        $resource->username = $comment->getUsername();
        $resource->content = $comment->getContent();
        /* $resource->html = strip_tags(
            (new Parsedown())
                ->setBreaksEnabled(true)
                ->setSafeMode(true)
                ->text($comment->getContent()),
            '<p><pre><code><ul><ol><li>'
        ); */
        $resource->createdAt = $comment->getCreatedAt()->getTimestamp();
        $resource->parent = null !== $comment->getParent() ? $comment->getParent()->getId() : null;
        /* if ($author && $uploaderHelper && $author->getAvatarName()) {
            $resource->avatar = $uploaderHelper->asset($author, 'avatarFile');
        } else {
            $resource->avatar = '/images/default.png';
        } */
        $resource->entity = $comment;
        $resource->userId = null !== $author ? $author->getId() : null;

        return $resource;
    }
}
