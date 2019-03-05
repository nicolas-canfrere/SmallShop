<?php

namespace Domain\Cart\Command;

use Domain\Cart\Event\ProductAddedToCartEvent;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Signature\ProductRepositoryInterface;

/**
 * Class AddProductToCartCommandHandler.
 */
class AddProductToCartCommandHandler implements CommandHandlerInterface
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
     * AddProductToCartCommandHandler constructor.
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
     * @param AddProductToCartCommandInterface|CommandInterface $command
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

        $this->cart->addItem($product, $command->getQuantity());

        $event = new ProductAddedToCartEvent($product, $command->getQuantity(), $command->getCustomer());

        $this->eventBus->dispatch($event);
    }
}
