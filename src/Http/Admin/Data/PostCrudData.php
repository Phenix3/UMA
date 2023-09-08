<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Attachment\Entity\Attachment;
use App\Domain\Blog\Entity\Post;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @property Post $entity
 */
// [Vich\Uploadable()]
class PostCrudData extends ContentData
{
    // [Vich\UploadableField(mapping: 'blog_posts', fileNameProperty: 'image')]
    // public ?Attachment $image = null;

    public ?Collection $categories;
}
