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

        $testListener = new TestListener();
        $listenerProvider = new EventListenerProvider();
        $listenerProvider->addListener($testListener);
        $eventBus = new EventBus($listenerProvider);
        $eventBus->dispatch(new TestEvent());

    }

    /**
     * @test
     */
    public function canStopPropagation()
    {
        $testListener = new TestListener();
        $testListenerTwo = new TestListenerTwo();
        $listenerProvider = new EventListenerProvider();
        $listenerProvider->addListener($testListener);
        $listenerProvider->addListener($testListenerTwo);
        $eventBus = new EventBus($listenerProvider);
        $eventBus->dispatch(new TestEventTwo());
        $eventBus->dispatch(new TestEvent());
    }
}