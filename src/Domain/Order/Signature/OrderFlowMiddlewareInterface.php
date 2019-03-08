<?php

namespace Domain\Order\Signature;

/**
 * Interface OrderFlowMiddlewareInterface
 */
interface OrderFlowMiddlewareInterface
{
    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(OrderInterface $order, callable $next);
}
