<?php

namespace Domain\Cart\Command;

use Domain\Cart\Event\CartClearEvent;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;

/**
 * Class ClearCartCommandHandler.
 */
class ClearCartCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CartInterface
     */
    private $cart;
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * ClearCartCommandHandler constructor.
     *
     * @param CartInterface $cart
     * @param EventBus      $eventBus
     */
    public function __construct(
        CartInterface $cart,
        EventBus $eventBus
    ) {
        $this->cart = $cart;
        $this->eventBus = $eventBus;
    }

    /**
     * @param ClearCartCommandInterface|CommandInterface $command
     *
     * @throws \Exception
     */
    public function handle(CommandInterface $command)
    {
        $this->cart->clear();

        $this->eventBus->dispatch(new CartClearEvent($command->getCustomer()));
    }
}
