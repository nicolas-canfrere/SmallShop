<?php

namespace Tests\Domain\Cart\Command;

use Domain\Cart\Cart;
use Domain\Cart\Command\ClearCartCommand;
use Domain\Cart\Command\ClearCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tests\Domain\Cart\CartTestCase;

class ClearCartCommandHandlerTest extends CartTestCase
{
    /**
     * @var CartInterface
     */
    protected $cart;
    /**
     * @var ClearCartCommandHandler
     */
    protected $handler;

    /**
     * @test
     */
    public function canClearTheCart()
    {
        $this->assertEquals(20, count($this->cart));
        $this->assertTrue($this->cart->itemIsRegistred('abc'));
        $this->assertTrue($this->cart->itemIsRegistred('def'));

        $this->handler->handle(new ClearCartCommand());

        $this->assertEquals(0, count($this->cart));
        $this->assertFalse($this->cart->itemIsRegistred('abc'));
        $this->assertFalse($this->cart->itemIsRegistred('def'));
    }

    protected function setUp(): void
    {
        $productA = $this->createProduct('abc', 'name', 1000);
        $productB = $this->createProduct('def', 'name', 1000);

        $this->cart = new Cart();

        $this->cart->addItem($productA, 10);
        $this->cart->addItem($productB, 10);

        $this->handler = new ClearCartCommandHandler(
            $this->createMock(EventDispatcherInterface::class),
            $this->cart
        );
    }
}
