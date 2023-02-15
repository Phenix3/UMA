<?php

namespace App\Domain\Application\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class DoctrinePropertyChangeEventListener
{
    public function __construct(private array $listeners, private PropertyAccessorInterface $propertyAccessor)
    {
        
    }

    public function prePersist($entity)
    {
        $listeners = $this->listeners[$entity::class] ?? null;
        if (null === $listeners) {
            return;
        }

        foreach ($listeners as $key => $propertyListeners) {
            if ($value = $this->propertyAccessor->getValue($entity, $key)) {
                foreach ($propertyListeners as $listener) {
                    $method = $listener['method'];
                    $listener['listener']->$method($entity, $value, null);
                }
            }
        }
    }

    public function preUpdate($entity, PreUpdateEventArgs $event)
    {
        $listeners = $this->listeners[$entity::class] ?? null;
        if (null === $listeners) {
            return;
        }

        $changeSet = $event->getEntityChangeSet();
        foreach ($listeners as $key => $propertyListeners) {
            if (in_array($key, array_keys($changeSet))) {
                foreach ($propertyListeners as $listener) {
                    $method = $listener['method'];
                    $listener['listener']->$method($entity, $changeSet[$key][1], $changeSet[$key][0]);
                }
            }
        }
    }
}