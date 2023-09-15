<?php

declare(strict_types=1);

namespace App\Domain\Comment;

class CommentCreatedEvent
{
    public function __construct(private readonly Comment $comment) {}

    public function getComment(): Comment
    {
        return $this->comment;
    }
}
