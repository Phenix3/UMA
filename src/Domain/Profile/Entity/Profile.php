<?php

declare(strict_types=1);

namespace App\Domain\Profile\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\TimestampableTrait;
use App\Domain\Auth\Entity\Traits\BlameableTrait;
use App\Domain\Auth\Entity\User;
use App\Domain\Profile\Repository\ProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\Table('`profile_profiles`')]
#[UniqueEntity(
    fields: ['username'],
    message: 'profile.username.unique',
    errorPath: 'username',
    ignoreNull: false,
    repositoryMethod: 'sluggifyAndFind'
)]
class Profile
{
    use BlameableTrait;
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(type: Types::STRING, length: 50)]
    #[Assert\NotBlank(message: 'profile.username.not_blank')]
    #[Assert\Regex(pattern: '/^[A-zÀ-ú\d ]{2,50}$/', message: 'profile.username.invalid')]
    #[Groups('searchable')]
    private ?string $username = null;

    #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
    #[Gedmo\Slug(fields: ['username'])]
    #[Groups('searchable')]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(max: 2500, maxMessage: 'profile.description.max_length')]
    #[Groups('searchable')]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Valid]
    private ?User $user = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[Assert\Valid]
    #[Groups('searchable')]
    private ?ProfilePicture $picture = null;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPicture(): ?ProfilePicture
    {
        return $this->picture;
    }

    public function setPicture(?ProfilePicture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /* #[Groups('searchable')]
    public function isIndexable(): bool
    {
        return $this->user?->isVerified();
    } */
}
