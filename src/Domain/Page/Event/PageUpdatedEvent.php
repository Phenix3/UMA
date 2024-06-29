<?php

declare(strict_types=1);

namespace App\Domain\Page\Event;

use App\Domain\Page\Entity\Page;

class PageUpdatedEvent
{
    public function __construct(private Page $page, private Page $previous) {}

    public function getPage(): Page
    {
        return $this->page;
    }

    public function getPrevious(): Page
    {
        return $this->page;
    }
}
