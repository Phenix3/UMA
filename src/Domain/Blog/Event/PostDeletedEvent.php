<?php

namespace App\Domain\Blog\Event;

use App\Domain\Application\Event\ContentDeletedEvent;
use App\Domain\Blog\Entity\Post;

class PostDeletedEvent extends ContentDeletedEvent
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }
}