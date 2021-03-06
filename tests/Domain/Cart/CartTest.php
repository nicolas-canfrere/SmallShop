<?php

namespace Tests\Domain\Cart;

use Domain\Cart\Cart;
use Money\Currency;
use Money\Money;

class CartTest extends CartTestCase
{
    /**
     * @test
     */
    public function canAddItem()
    {
        $cart    = new Cart();
        $product = $this->createProduct('abc', 'name', 1000);

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
        $product = $product = $this->createProduct('abc', 'name', 1000);

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
        $product = $product = $this->createProduct('abc', 'name', 1000);

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
        $productA = $product = $this->createProduct('abc', 'name', 1000);
        $productB = $product = $this->createProduct('def', 'name', 1000);

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
        $product = $product = $this->createProduct('abc', 'name', 1000);

        $total = new Money(10000, new Currency('EUR'));

        $cart->addItem($product, 10);

        $this->assertTrue($total->equals($cart->totalPrice()));
    }
}
