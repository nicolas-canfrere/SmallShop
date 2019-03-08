<?php

namespace Domain\Order\Signature;

/**
 * Interface OrderManagerInterface
 */
interface OrderManagerInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return mixed
     */
    public function handle(OrderInterface $order);
}
