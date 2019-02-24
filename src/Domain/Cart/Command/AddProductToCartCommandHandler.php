<?php

namespace Domain\Cart\Command;

use Domain\Cart\Signature\CartInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AddProductToCartCommandHandler.
 */
class AddProductToCartCommandHandler implements CommandHandlerInterface
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
     * AddProductToCartCommandHandler constructor.
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
     * @param AddProductToCartCommand $command
     *
     * @throws ProductNotFoundException
     */
    public function handle(AddProductToCartCommand $command)
    {
        $product = $this->productRepository->oneById($command->productId);

        if ( ! $product) {
            throw new ProductNotFoundException('product not found');
        }

        $this->cart->addItem($product, $command->quantity);

        // TODO dispatch event !
    }
}
