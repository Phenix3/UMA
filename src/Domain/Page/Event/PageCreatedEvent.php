<?php

declare(strict_types=1);

namespace App\Domain\Page\Event;

use App\Domain\Page\Entity\Page;

class PageCreatedEvent
{
    public function __construct(private Page $page) {}

    public function getPage(): Page
    {
        return $this->page;
    }
}
