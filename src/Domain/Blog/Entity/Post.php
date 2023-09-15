<?php

declare(strict_types=1);

namespace App\Domain\Blog\Entity;

use App\Domain\Application\Entity\Content;
use App\Domain\Blog\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table('`blog_posts`')]
class Post extends Content
{
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getCategories(): ?Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
