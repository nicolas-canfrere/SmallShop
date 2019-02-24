<?php

namespace Domain\Core\Event;

/**
 * Interface EventBusInterface.
 */
interface EventBusInterface
{
    /**
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function dispatch(EventInterface $event);
}
