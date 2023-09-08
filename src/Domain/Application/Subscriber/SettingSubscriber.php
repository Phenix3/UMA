<?php

declare(strict_types=1);

namespace App\Domain\Application\Subscriber;

use App\Domain\Application\Event\SettingCreatedEvent;
use App\Domain\Application\Event\SettingDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class SettingSubscriber implements EventSubscriberInterface
{
    public function __construct(private TagAwareCacheInterface $cache)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SettingCreatedEvent::class => 'onSettingCreated',
            SettingDeletedEvent::class => 'onSettingDeleted',
        ];
    }

    public function onSettingCreated(SettingCreatedEvent $event): void
    {
        $this->invalidateCahce();
    }

    public function onSettingDeleted(SettingDeletedEvent $event): void
    {
        $this->invalidateCahce();
    }

    public function invalidateCahce()
    {
        $this->cache->invalidateTags(['global_settings_tag']);
    }
}
