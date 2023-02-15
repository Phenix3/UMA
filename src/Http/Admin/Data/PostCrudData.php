<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Validator\Slug;
use App\Domain\Blog\Entity\Post;
use App\Domain\Attachment\Entity\Attachment;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

/**
 * @property Post $entity
 */
class PostCrudData extends AutomaticCrudData
{
    public ?string $title;

    public ?string $content;

    public ?Attachment $image;

    public ?Collection $categories;
}
