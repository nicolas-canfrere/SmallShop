<?php

namespace Domain\Cart\Command;

use Domain\Cart\Cart;
use Domain\Cart\Event\ProductAllRemovedFromCartEvent;
use Domain\Cart\Event\ProductRemovedFromCartEvent;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Signature\ProductRepositoryInterface;

/**
 * Class RemoveProductFromCartCommandHandler.
 */
class RemoveProductFromCartCommandHandler implements CommandHandlerInterface
{

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CartInterface
     */
    private $cart;
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * RemoveProductFromCartCommandHandler constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param CartInterface $cart
     * @param EventBus $eventBus
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CartInterface $cart,
        EventBus $eventBus
    ) {
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->eventBus = $eventBus;
    }

    /**
     * @param RemoveProductFromCartCommandInterface|CommandInterface $command
     *
     * @throws ProductNotFoundException
     * @throws \Domain\Cart\Exception\CartException
     */
    public function handle(CommandInterface $command)
    {
        $product = $this->productRepository->oneById($command->getProductId());

        if (!$product) {
            throw new ProductNotFoundException('product not found');
        }

        if (Cart::ALL_PRODUCTS_IN_ROW == $command->getQuantity()) {
            $this->cart->deleteRow($command->getProductId());
            $event = new ProductAllRemovedFromCartEvent($product, $command->getCustomer());

        } else {
            $this->cart->removeItem($product, $command->getQuantity());
            $event = new ProductRemovedFromCartEvent($product, $command->getQuantity(), $command->getCustomer());
        }

        $this->eventBus->dispatch($event);
    }
}
