<?php

namespace App\Domain\Comment;

abstract class CommentData
{
    public ?string $id = null;

    public ?string $username = null;

    public string $content = '';

    public ?string $avatar = null;

    public ?string $target = null;

    public ?string $email = null;

    public int $createdAt = 0;

    public ?string $parent = null;

    public ?Comment $entity = null;

    public ?string $userId = null;
}
