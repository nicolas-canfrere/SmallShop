<?php

namespace Domain\EventSourcing;

abstract class AbstractAggregate implements AggregateInterface
{
    /**
     * @var array
     */
    protected $uncommittedEvents = [];

    public static function initialize(EventStream $loadedEvents)
    {
        $static = new static();
        foreach ($loadedEvents as $event) {
            $static->handle($event);
        }

        return $static;
    }

    public function apply($event)
    {
        $this->handle($event);
        $this->uncommittedEvents[] = $event;
    }

    public function handle($event)
    {
        $classParts = explode('\\', get_class($event));
        $method     = 'apply'.end($classParts);
        if ( ! method_exists($this, $method)) {
            return;
        }
        $this->$method($event);
    }

    public function getUncommittedEvents(): EventStream
    {
        $uncommittedEvents       = $this->uncommittedEvents;
        $this->uncommittedEvents = [];

        return new EventStream($uncommittedEvents);
    }
}
