<?php

declare(strict_types=1);

namespace App\Domain\Blog\Event;

use App\Domain\Application\Event\ContentUpdatedEvent;
use App\Domain\Blog\Entity\Post;

class PostUpdatedEvent extends ContentUpdatedEvent
{
    public function __construct(Post $content, Post $previous)
    {
        parent::__construct($content, $previous);
    }
}
