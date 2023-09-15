<?php

declare(strict_types=1);

namespace App\Domain\Blog\Event;

use App\Domain\Application\Event\ContentCreatedEvent;
use App\Domain\Blog\Entity\Post;

class PostCreatedEvent extends ContentCreatedEvent
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }
}
