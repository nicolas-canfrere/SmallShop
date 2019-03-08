<?php

namespace Domain\Order\Signature;

/**
 * Interface OrderFlowInterface
 */
interface OrderFlowInterface
{
    /**
     * @param OrderInterface $order
     *
     * @return mixed
     */
    public function handle(OrderInterface $order);
}
