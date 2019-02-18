<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/02/19
 * Time: 22:06
 */

namespace Domain\Tests\Cart;


use Domain\Cart\Cart;
use Domain\Product\Product;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @test
     */
    public function canAddItem()
    {
        $cart    = new Cart();
        $product = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );

        $cart->addItem($product, 10);
        $this->assertEquals(10, count($cart));
        $this->assertTrue($cart->itemIsRegistred('abc'));
        $cart->addItem($product, 10);
        $this->assertEquals(20, count($cart));
    }

    /**
     * @test
     */
    public function canRemoveItem()
    {
        $cart    = new Cart();
        $product = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );

        $cart->addItem($product, 10);
        $this->assertEquals(10, count($cart));
        $this->assertTrue($cart->itemIsRegistred('abc'));

        $cart->removeItem($product, 5);
        $this->assertEquals(5, count($cart));
    }

    /**
     * @test
     */
    public function canDeleteRow()
    {
        $cart    = new Cart();
        $product = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );

        $cart->addItem($product, 10);
        $this->assertEquals(10, count($cart));
        $this->assertTrue($cart->itemIsRegistred('abc'));

        $cart->deleteRow('abc');
        $this->assertEquals(0, count($cart));
        $this->assertFalse($cart->itemIsRegistred('abc'));
    }

    /**
     * @test
     */
    public function canBeCleared()
    {
        $cart     = new Cart();
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
        $cart->addItem($productA, 10);
        $cart->addItem($productB, 10);
        $this->assertEquals(20, count($cart));
        $this->assertTrue($cart->itemIsRegistred('abc'));
        $this->assertTrue($cart->itemIsRegistred('def'));

        $cart->clear();
        $this->assertEquals(0, count($cart));
        $this->assertFalse($cart->itemIsRegistred('abc'));
        $this->assertFalse($cart->itemIsRegistred('def'));
    }

    /**
     * @test
     */
    public function canCalculateTotalPrice()
    {
        $cart    = new Cart();
        $product = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );

        $total = new Money(10000, new Currency('EUR'));

        $cart->addItem($product, 10);

        $this->assertTrue($total->equals($cart->totalPrice()));
    }
}
