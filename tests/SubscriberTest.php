<?php

namespace App\Tests\;

use App\Tests\EventSubscriberTest;
use App\\Subscriber;
use App\Domain\Application\Event\SettingCreatedEvent;
use App\Domain\Application\Event\SettingDeletedEvent;

class SubscriberTest extends EventSubscriberTest
{

    public function testSubscribeToEvents()
    {
        $this->assertSubscribeTo(Subscriber::class, SettingCreatedEvent::class);
        $this->assertSubscribeTo(Subscriber::class, SettingDeletedEvent::class);
    }

    public function testEventTriggersTheRightThing()
    {
        $event = new SettingCreatedEvent();
        $service->expects($this->once())->method()->with();
        $this->dispatch($subscriber, $event);
    }
}
