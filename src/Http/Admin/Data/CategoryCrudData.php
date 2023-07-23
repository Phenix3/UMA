<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Blog\Entity\Category;
use App\Validator\Slug;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property Category $entity
 */
class CategoryCrudData extends AutomaticCrudData
{
    public ?string $name;
}
