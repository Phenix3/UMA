<?php

namespace App\Domain\Application\Event;

use App\Domain\Application\Entity\Setting;

class SettingDeletedEvent
{
    public function __construct(private Setting $setting){}
    
    public function getSetting(): Setting
    {
        return $this->setting;
    }
}