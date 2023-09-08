<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Slider\Entity\Slider;

/**
 * @property Slider $entity
 */
class SliderCrudData extends AutomaticCrudData
{
    public ?string $name = null;

    public ?string $description = null;
}
