<?php

namespace Tests\Domain\Cart\Command;

use Bundles\CartBundle\Command\RemoveProductFromCartCommand;
use Domain\Cart\Cart;
use Domain\Cart\Command\RemoveProductFromCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventListenerProvider;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Repository\InMemoryProductRepository;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Tests\Domain\Cart\CartTestCase;

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

        $command            = RemoveProductFromCartCommand::fromArray(
            [
                'id'       => $this->product->getId(),
                'quantity' => 1,
                'customer'=>null,
            ]
        );

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

        $command            = RemoveProductFromCartCommand::fromArray(
            [
                'id'       => $this->product->getId(),
                'quantity' => 2,
                'customer'=>null,
            ]
        );

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

        $command            = RemoveProductFromCartCommand::fromArray(
            [
                'id'       => 'throw-exception!',
                'quantity' => 1,
                'customer'=>null,
            ]
        );
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
            $this->productRepository,
            $this->cart, new EventBus(new EventListenerProvider())
        );
    }
}
