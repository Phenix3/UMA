<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Slider\Entity\Slider;
use App\Domain\Slider\Entity\SliderItem;
use App\Http\Admin\Form\SliderItemForm;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @property SliderItem $entity
 */
class SliderItemCrudData extends AutomaticCrudData
{
    public ?string $title = null;

    public ?string $link = null;

    public ?UploadedFile $imageFile = null;

    public ?string $description = null;

    public ?Slider $slider = null;

    public function getFormClass(): string
    {
        return SliderItemForm::class;
    }
}
