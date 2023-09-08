<?php

namespace App\Http\Admin\Data;

use App\Domain\Application\Entity\Content;
use App\Domain\Attachment\Entity\Attachment;

/**
 * @var Content $entity
 */
class ContentData extends AutomaticCrudData
{
    public ?string $title;

    public ?string $slug;

    public ?string $content;

    public ?Attachment $image = null;

    public ?\DateTimeInterface $publishedAt = null;

    public ?string $metaKeywords;

    public ?string $metaDescription;
}
