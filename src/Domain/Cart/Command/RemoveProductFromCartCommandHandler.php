<?php

namespace Domain\Cart\Command;

use Domain\Cart\Cart;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class RemoveProductFromCartCommandHandler.
 */
class RemoveProductFromCartCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CartInterface
     */
    private $cart;

    /**
     * RemoveProductFromCartCommandHandler constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProductRepositoryInterface $productRepository
     * @param CartInterface $cart
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ProductRepositoryInterface $productRepository,
        CartInterface $cart
    ) {
        $this->eventDispatcher   = $eventDispatcher;
        $this->productRepository = $productRepository;
        $this->cart              = $cart;
    }

    /**
     * @param RemoveProductFromCartCommand $command
     *
     * @throws ProductNotFoundException
     */
    public function handle(RemoveProductFromCartCommand $command)
    {
        $product = $this->productRepository->oneById($command->productId);

        if ( ! $product) {
            throw new ProductNotFoundException('product not found');
        }

        if (Cart::ALL_PRODUCTS_IN_ROW == $command->quantity) {
            $this->cart->deleteRow($command->productId);
            // TODO dispatch event !
        } else {
            $this->cart->removeItem($product, $command->quantity);
            // TODO dispatch event !
        }
    }
}
