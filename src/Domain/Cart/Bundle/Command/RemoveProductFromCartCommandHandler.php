<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 08:22
 */

namespace Domain\Cart\Bundle\Command;


use Domain\Cart\Cart;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ProductRepositoryInterface $productRepository,
        CartInterface $cart
    ) {
        $this->eventDispatcher   = $eventDispatcher;
        $this->productRepository = $productRepository;
        $this->cart              = $cart;
    }

    public function handle(RemoveProductFromCartCommand $command)
    {
        $product = $this->productRepository->oneById($command->productId);

        if ( ! $product) {
            throw new \Exception('unknown product');
        }

        if ($command->quantity == Cart::ALL_PRODUCTS_IN_ROW) {
            $this->cart->deleteRow($command->productId);
        } else {
            $this->cart->removeItem($product, $command->quantity);
        }
    }
}
