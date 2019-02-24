<?php

namespace Domain\Core\Event;

/**
 * Interface ListenerInterface.
 */
interface ListenerInterface
{
    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void;

    /**
     * @return string
     */
    public function listenTo(): string;
}
