<?php

namespace Domain\Core\Event;


class EventListenerProvider implements EventListenerProviderInterface
{
    protected $listeners = [];

    public function addListener(ListenerInterface $listener)
    {
        $eventname = $listener->listenTo();
        if (!array_key_exists($eventname, $this->listeners)) {
            $this->listeners[$eventname] = [];
        }
        $this->listeners[$eventname][] = $listener;
    }

    public function getListenersForEvent(EventInterface $event): array
    {
        if (array_key_exists($event->getName(), $this->listeners)) {
            return $this->listeners[$event->getName()];
        }
        return [];
    }
}