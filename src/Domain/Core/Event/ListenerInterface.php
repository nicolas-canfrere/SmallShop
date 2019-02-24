<?php

namespace Domain\Core\Event;

interface ListenerInterface
{
    public function handle(EventInterface $event): void;

    public function listenTo(): string;
}
