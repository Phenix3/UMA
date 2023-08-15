<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Validator\Slug;
use App\Domain\Slider\Entity\Slider;
use App\Domain\Slider\Entity\SliderItem;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Admin\Form\SliderItemForm;

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
