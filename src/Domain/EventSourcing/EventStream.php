<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 22:45
 */

namespace Domain\EventSourcing;


use Traversable;

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
