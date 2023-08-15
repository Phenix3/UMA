<?php

namespace App\Domain\Application\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait HasSeoMetaTrait
{
    #[ORM\Column(nullable: true)]
    private ?string $metaKeywords = '';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $metaDescription = '';

    /**
     * Get the value of metaKeywords
     */ 
    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    /**
     * Set the value of metaKeywords
     *
     * @return  self
     */ 
    public function setMetaKeywords(?string $metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get the value of metaDescription
     */ 
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * Set the value of metaDescription
     *
     * @return  self
     */ 
    public function setMetaDescription(?string $metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }
}