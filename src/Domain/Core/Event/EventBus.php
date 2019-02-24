<?php

namespace Domain\Core\Event;

/**
 * Class EventBus.
 */
class EventBus implements EventBusInterface
{
    /**
     * @var EventListenerProviderInterface
     */
    protected $listenerProvider;

    /**
     * EventBus constructor.
     *
     * @param EventListenerProviderInterface $listenerProvider
     */
    public function __construct(EventListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(EventInterface $event)
    {
        $listeners = $this->listenerProvider->getListenersForEvent($event);

        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }
            call_user_func_array([$listener, 'handle'], [$event]);
        }
    }
}
