<?php

declare(strict_types=1);

namespace App\Domain\Slider\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Slider\Repository\SliderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SliderRepository::class)]
#[ORM\Table('`slider_sliders`')]
class Slider
{
    use IdentifiableTrait;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'slider', targetEntity: SliderItem::class, orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
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

    /**
     * @return Collection<int, SliderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(SliderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setSlider($this);
        }

        return $this;
    }

    public function removeItem(SliderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getSlider() === $this) {
                $item->setSlider(null);
            }
        }

        return $this;
    }
}
