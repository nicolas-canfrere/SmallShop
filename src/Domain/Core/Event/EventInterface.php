<?php

namespace Domain\Core\Event;


interface EventInterface
{
    public function getName(): string;

    public function stopPropagation(): void;

    public function isPropagationStopped(): bool;
}