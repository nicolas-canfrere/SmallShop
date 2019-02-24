<?php

namespace Domain\Core\Event;

interface EventBusInterface
{
    public function dispatch(EventInterface $event);
}
