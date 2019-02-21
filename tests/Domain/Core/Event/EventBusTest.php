<?php

namespace Domain\Tests\Core\Event;


use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventListenerProvider;
use PHPUnit\Framework\TestCase;

class EventBusTest extends TestCase
{
    /**
     * @test
     */
    public function canDispatch()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(TestEvent::class . ' dispatched');
        $testListener = new TestListener();
        $listenerProvider = new EventListenerProvider();
        $listenerProvider->addListener($testListener);
        $eventBus = new EventBus($listenerProvider);
        $eventBus->dispatch(new TestEvent());

    }
}