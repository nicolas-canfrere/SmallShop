<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 17:49
 */

namespace Domain\Cart\Command;


use Domain\Cart\Signature\CartInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ProductRepositoryInterface $productRepository,
        CartInterface $cart
    ) {
        $this->eventDispatcher   = $eventDispatcher;
        $this->productRepository = $productRepository;
        $this->cart              = $cart;
    }

    public function handle(AddProductToCartCommand $command)
    {
        $product = $this->productRepository->oneById($command->productId);

        if ( ! $product) {
            throw new \Exception('unknown product');
        }

        // add to cart !

        $this->cart->addItem($product, $command->quantity);

    }
}
