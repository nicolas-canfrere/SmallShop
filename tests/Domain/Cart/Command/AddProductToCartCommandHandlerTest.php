<?php

namespace Tests\Domain\Cart\Command;

use Bundles\CartBundle\Command\AddProductToCartCommand;
use Domain\Cart\Cart;
use Domain\Cart\Command\AddProductToCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventListenerProvider;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Repository\InMemoryProductRepository;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Tests\Domain\Cart\CartTestCase;

class AddProductToCartCommandHandlerTest extends CartTestCase
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
     * @var AddProductToCartCommandHandler
     */
    protected $handler;

    /**
     * @test
     */
    public function canAddProductToCart()
    {
        $this->assertEquals(0, count($this->cart));

        $command = AddProductToCartCommand::fromArray(
            [
                'id'       => 'abc',
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
    public function mustThrowExceptionWhenProductNotExist()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('product not found');

        $command = AddProductToCartCommand::fromArray(
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

        $this->handler = new AddProductToCartCommandHandler(
            $this->productRepository,
            $this->cart,
            new EventBus(new EventListenerProvider())
        );
    }
}
