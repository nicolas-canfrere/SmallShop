<?php

namespace Domain\Tests\Cart\Command;

use Bundles\ProductBundle\Repository\InMemoryProductRepository;
use Domain\Cart\Cart;
use Domain\Cart\Command\RemoveProductFromCartCommand;
use Domain\Cart\Command\RemoveProductFromCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Domain\Tests\Cart\CartTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RemoveProductFromCartCommandHandlerTest extends CartTestCase
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var ProductInterface
     */
    protected $product;
    /**
     * @var CartInterface
     */
    protected $cart;
    /**
     * @var RemoveProductFromCartCommandHandler
     */
    protected $handler;

    /**
     * @test
     */
    public function canRemoveProductFromCart()
    {
        $this->assertEquals(2, count($this->cart));

        $command            = new RemoveProductFromCartCommand();
        $command->productId = $this->product->getId();
        $command->quantity  = 1;

        $this->handler->handle($command);

        $this->assertEquals(1, count($this->cart));
        $this->assertTrue($this->cart->itemIsRegistred('abc'));
    }

    /**
     * @test
     */
    public function canRemoveAllProductFromCart()
    {
        $this->assertEquals(2, count($this->cart));

        $command            = new RemoveProductFromCartCommand();
        $command->productId = $this->product->getId();
        $command->quantity  = 2;

        $this->handler->handle($command);

        $this->assertEquals(0, count($this->cart));
        $this->assertFalse($this->cart->itemIsRegistred('abc'));
    }

    /**
     * @test
     */
    public function mustThrowExceptionWhenProductNotExist()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('product not found');

        $command            = new RemoveProductFromCartCommand();
        $command->productId = 'throw-exception!';
        $this->handler->handle($command);
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->product           = $this->createProduct('abc', 'name', 1000);
        $this->productRepository->save($this->product);
        $this->cart = new Cart();

        $this->cart->addItem($this->product, 2);

        $this->handler = new RemoveProductFromCartCommandHandler(
            $this->createMock(EventDispatcherInterface::class),
            $this->productRepository,
            $this->cart
        );
    }
}
