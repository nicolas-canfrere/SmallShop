<?php

namespace Domain\Core\Event;

interface EventListenerProviderInterface
{
    public function addListener(ListenerInterface $listener);

    public function getListenersForEvent(EventInterface $event): array;
}
