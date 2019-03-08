<?php

namespace Tests\Domain\Order;


use Domain\Order\Order;
use Domain\Order\Signature\OrderInterface;
use Domain\Order\Signature\OrderItemInterface;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     */
    public function canAddItem()
    {
        $order = new Order();

        $item = $this->createMock(OrderItemInterface::class);
        $item->method('getId')->willReturn('abc');

        $order->addOrderItem($item);

        $this->assertTrue($order->getOrderItems()->contains($item));
    }

    /**
     * @test
     */
    public function staticCreation()
    {


        $order = Order::create('abc');


        $this->assertEquals(OrderInterface::ORDER_STATE_STARTED, $order->getState());
    }
}
