<?php

namespace App\Domain\Auth\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\TimestampableTrait;
use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Profile\Entity\Profile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('`auth_users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'user.email.not_blank')]
    #[Assert\Length(max: 180, maxMessage: 'user.email.max_length')]
    #[Assert\Email(message: 'user.email.invalid')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[Assert\When(
        expression: 'this.getPlainPassword() not in [null, ""]',
        constraints: [
            new UserPassword(message: 'user.current_password.invalid'),
        ],
        groups: ['UserEdit'],
    )]
    private ?string $currentPassword = null;

    #[Assert\Regex(
        pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        message: 'user.password.valid'
    )]
    #[Assert\NotCompromisedPassword(message: 'user.password.not_compromised')]
    #[Assert\NotBlank(message: 'user.password.not_blank', groups: ['Registration'])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private array $roles = [];

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[Assert\Valid()]
    private ?Profile $profile = null;

    public function __serialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            // 'verified' => $this->verified,
        ];
    }

    public function __unserialize(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        // $this->verified = $data['verified'] ?? false;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(string $currentPassword): self
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        $this->profile = $profile;

        return $this;
    }
}
