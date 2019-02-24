<?php

namespace Domain\Core\Event;

/**
 * Class Event.
 */
class Event implements EventInterface
{
    /**
     * @var bool
     */
    protected $isPropagationStopped = false;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return get_class($this);
    }

    /**
     * {@inheritdoc}
     */
    public function stopPropagation(): void
    {
        $this->isPropagationStopped = true;
    }

    /**
     * {@inheritdoc}
     */
    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }
}
