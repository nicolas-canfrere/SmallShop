<?php

namespace Domain\Cart\Command;

use Domain\Cart\Signature\CartInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ClearCartCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var CartInterface
     */
    private $cart;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        CartInterface $cart
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->cart            = $cart;
    }

    public function handle(ClearCartCommand $command)
    {
        $this->cart->clear();

        // TODO dispatch event !
    }
}
