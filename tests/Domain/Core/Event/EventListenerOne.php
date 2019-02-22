<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 22/02/19
 * Time: 09:11
 */

namespace Domain\Tests\Core\Event;


use Domain\Core\Event\EventInterface;
use Domain\Core\Event\ListenerInterface;

class EventListenerOne implements ListenerInterface
{

    public function handle(EventInterface $event): void
    {
        // TODO: Implement handle() method.
    }

    public function listenTo(): string
    {
        return EventOne::class;
    }
}