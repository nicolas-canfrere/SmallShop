<?php

namespace Tests\Domain\Core\Event;

use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Event\EventListenerProvider;
use Domain\Core\Event\EventListenerProviderInterface;
use PHPUnit\Framework\TestCase;

class EventBusTest extends TestCase
{
    /**
     * @var EventListenerProviderInterface
     */
    protected $provider;
    /**
     * @var EventBusInterface
     */
    protected $eventBus;

    protected function setUp(): void
    {
        $this->provider = new EventListenerProvider();
        $this->eventBus = new EventBus($this->provider);
    }

    /**
     * @test
     */
    public function canDispatch()
    {
        $event = new EventOne();
        $listener = $this->getMockBuilder(EventListenerOne::class)
            ->setMethods(['handle'])
            ->getMock();
        $listener->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($event));
        $this->provider->addListener($listener);
        $this->eventBus->dispatch($event);
    }

    public function canStopPropagation()
    {
        $event = new EventOne();
        $event->stopPropagation();
        $listener = $this->getMockBuilder(EventListenerOne::class)
            ->setMethods(['handle'])
            ->getMock();
        $listener->expects($this->never())
            ->method('handle');
        $this->provider->addListener($listener);
        $this->eventBus->dispatch($event);
    }
}
