<?php

namespace Domain\Core\Event;

/**
 * Class EventListenerProvider.
 */
class EventListenerProvider implements EventListenerProviderInterface
{
    /**
     * @var ListenerInterface[]
     */
    protected $listeners = [];

    /**
     * {@inheritdoc}
     */
    public function addListener(ListenerInterface $listener): void
    {
        $eventname = $listener->listenTo();
        if (!array_key_exists($eventname, $this->listeners)) {
            $this->listeners[$eventname] = [];
        }
        $this->listeners[$eventname][] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function getListenersForEvent(EventInterface $event): array
    {
        if (array_key_exists($event->getName(), $this->listeners)) {
            return $this->listeners[$event->getName()];
        }

        return [];
    }
}
