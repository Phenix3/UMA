<?php

declare(strict_types=1);

namespace App\Domain\Blog\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\ToggleableTrait;
use App\Domain\Blog\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table('`blog_categories`')]
class Category implements \Stringable
{
    use IdentifiableTrait;
    use ToggleableTrait;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $slug = '';

    #[ORM\Column(length: 255, options: ['unsigned' => true])]
    private int $postsCount = 0;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
    #[ORM\JoinTable('`blog_categories_posts`')]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Set the value of id.
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of slug.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug.
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of ostsCount.
     */
    public function getPostsCount(): int
    {
        return $this->postsCount;
    }

    /**
     * Set the value of ostsCount.
     */
    public function setPostsCount(int $ostsCount): self
    {
        $this->postsCount = $ostsCount;

        return $this;
    }

    /**
     * Get the value of posts.
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->removeElement($post);

        return $this;
    }
}
