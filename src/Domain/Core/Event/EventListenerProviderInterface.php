<?php

namespace Domain\Core\Event;

/**
 * Interface EventListenerProviderInterface.
 */
interface EventListenerProviderInterface
{
    /**
     * @param ListenerInterface $listener
     *
     * @return mixed
     */
    public function addListener(ListenerInterface $listener): void;

    /**
     * @param EventInterface $event
     *
     * @return array
     */
    public function getListenersForEvent(EventInterface $event): array;
}
