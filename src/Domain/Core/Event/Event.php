<?php

namespace Domain\Core\Event;

class Event implements EventInterface
{
    /**
     * @var bool
     */
    protected $isPropagationStopped = false;

    public function getName(): string
    {
        return get_class($this);
    }

    public function stopPropagation(): void
    {
        $this->isPropagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }
}
