<?php

declare(strict_types=1);

namespace App\Domain\Comment;

use App\Domain\Application\Entity\Content;
use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\TimestampableTrait;
use App\Domain\Application\Entity\Traits\ToggleableTrait;
use App\Domain\Auth\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table('`comment_comments`')]
class Comment
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use ToggleableTrait;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, length: 180, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $content = '';

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: true)]
    private ?User $author = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'replies', fetch: 'LAZY')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?self $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    /**
     * @var Collection<string, Comment>
     */
    private Collection $replies;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE', nullable: true, name: 'content_id')]
    private Content $target;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->replies = new ArrayCollection();
    }

    public function getUsername(): string
    {
        if (null !== $this->author) {
            return $this->author->getUsername();
        }

        return $this->username ?: '';
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getTarget(): ?Content
    {
        return $this->target;
    }

    public function setTarget(Content $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function addReply(self $comment): self
    {
        if (!$this->replies->contains($comment)) {
            $this->replies->add($comment);
            $comment->setParent($this);
        }

        return $this;
    }

    public function getReplies(): Collection
    {
        return $this->replies;
    }
}
