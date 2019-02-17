<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 21:17
 */

namespace Domain\Stock;

use Domain\EventSourcing\AbstractAggregate;
use Domain\Stock\ES\Event\CreatedEvent;

class Stock extends AbstractAggregate
{

    /**
     * @var string
     */
    protected $id;

    public static function create(string $id)
    {
        $static = new static();
        $static->apply(new CreatedEvent($id));

        return $static;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function applyCreatedEvent(CreatedEvent $event)
    {
        $this->id = $event->getId();
    }


}
