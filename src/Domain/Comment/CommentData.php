<?php

declare(strict_types=1);

namespace App\Domain\Comment;

use Symfony\Component\Uid\Uuid;

abstract class CommentData
{
    public mixed $id = null;

    public ?string $username = null;

    public string $content = '';

    public ?string $avatar = null;

    public Uuid|string|null $target = null;

    public ?string $email = null;

    public int $createdAt = 0;

    public Uuid|string|null $parent = null;

    public ?Comment $entity = null;

    public ?Uuid $userId = null;
}
