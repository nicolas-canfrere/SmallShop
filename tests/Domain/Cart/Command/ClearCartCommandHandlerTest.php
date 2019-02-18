<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/02/19
 * Time: 21:58
 */

namespace Domain\Tests\Cart\Command;


use Domain\Cart\Cart;
use Domain\Cart\Command\ClearCartCommand;
use Domain\Cart\Command\ClearCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Domain\Product\Product;
use Domain\Product\Signature\ProductInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ClearCartCommandHandlerTest extends TestCase
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
        $productA = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );
        $productB = Product::create(
            'def',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );

        $this->cart = new Cart();

        $this->cart->addItem($productA, 10);
        $this->cart->addItem($productB, 10);

        $this->handler = new ClearCartCommandHandler(
            $this->createMock(EventDispatcherInterface::class),
            $this->cart
        );
    }
}
