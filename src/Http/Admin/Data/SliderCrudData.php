<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Validator\Slug;
use App\Domain\Slider\Entity\Slider;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property Slider $entity
 */
class SliderCrudData extends AutomaticCrudData
{
    public ?string $name = null;
    
    public ?string $description = null;
}
