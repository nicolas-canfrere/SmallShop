<?php

namespace Domain\Order;

use Domain\Order\Signature\OrderItemInterface;

/**
 * Class OrderItem.
 */
class OrderItem implements OrderItemInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }
}
