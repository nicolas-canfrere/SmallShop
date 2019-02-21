<?php

namespace Domain\Core\Event;


interface EventInterface
{
    public function getName(): string;

    public function stopPropagation(bool $stop = false);

    public function isPropagationStopped(): bool;
}