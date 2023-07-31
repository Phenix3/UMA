<?php

namespace App\Domain\Slider\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\TimestampableTrait;
use App\Domain\Slider\Repository\SliderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SliderItemRepository::class)]
#[ORM\Table('`slider_slider_items`')]
#[Vich\Uploadable()]
/**
 * @Vich\Uploadable() 
 */
class SliderItem
{
    use IdentifiableTrait;
    use TimestampableTrait;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;
    
    /**
     * @Vich\UploadableField(mapping="sliders", fileNameProperty="image")
     */
    #[Vich\UploadableField(mapping: "sliders", fileNameProperty: "image")]
    private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Slider $slider = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getSlider(): ?Slider
    {
        return $this->slider;
    }

    public function setSlider(?Slider $slider): self
    {
        $this->slider = $slider;

        return $this;
    }
}
