<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ToggleableTrait
{
    #[ORM\Column(nullable: true, options: ['default' => true])]
    private ?bool $enabled = false;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
	
	/**
	 * @param bool|null $enabled 
	 * @return self
	 */
	public function setEnabled(?bool $enabled): self {
		$this->enabled = $enabled;
		return $this;
	}
}