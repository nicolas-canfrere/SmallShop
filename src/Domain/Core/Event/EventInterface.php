<?php

namespace Domain\Core\Event;

/**
 * Interface EventInterface.
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName(): string;


    public function stopPropagation(): void;

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool;
}
