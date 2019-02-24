<?php

namespace Domain\EventSourcing;

class EventStream implements \IteratorAggregate
{
    protected $events = [];

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }
}
