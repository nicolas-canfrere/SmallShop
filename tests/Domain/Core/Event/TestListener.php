<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 22/02/19
 * Time: 00:13
 */

namespace Domain\Tests\Core\Event;


use Domain\Core\Event\EventInterface;
use Domain\Core\Event\ListenerInterface;

class TestListener implements ListenerInterface
{

    public function handle(EventInterface $event): void
    {
        throw new \Exception($this->listenTo() . ' dispatched');
    }

    public function listenTo(): string
    {
        return TestEvent::class;
    }
}