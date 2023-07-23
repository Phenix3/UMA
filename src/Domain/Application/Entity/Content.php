<?php

namespace App\Domain\Application\Entity;

use App\Domain\Application\Entity\Traits\HasSeoMetaTrait;
use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\ToggleableTrait;
use App\Domain\Application\Repository\ContentRepository;
use App\Domain\Attachment\Entity\Attachment;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ORM\Table("`application_contents`")]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
abstract class Content
{
    use IdentifiableTrait;
    use TimestampableEntity;
    use ToggleableTrait;
    use HasSeoMetaTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = '';

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = '';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = '';

    #[ORM\ManyToOne(targetEntity: Attachment::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'attachment_id', referencedColumnName: 'id')]
    private ?Attachment $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $isCommentable = true;


    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getExcerpt(): string
    {
        if (null === $this->content) {
            return '';
        }
        $parts = preg_split("/(\r\n|\r|\n){2}/", $this->content);
        return false === $parts ? '' : strip_tags($parts[0]);
    }

    /**
     * Get the value of publishedAt
     */
    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Set the value of publishedAt
     */
    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage(): ?Attachment
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */
    public function setImage(?Attachment $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of isCommentable
     */ 
    public function getIsCommentable(): bool
    {
        return $this->isCommentable;
    }

    /**
     * Set the value of isCommentable
     *
     * @return  self
     */ 
    public function setIsCommentable(?bool $isCommentable): self
    {
        $this->isCommentable = $isCommentable;

        return $this;
    }
}
