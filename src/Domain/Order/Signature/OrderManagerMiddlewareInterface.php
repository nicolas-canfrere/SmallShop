<?php

namespace Domain\Order\Signature;

/**
 * Interface OrderManagerMiddlewareInterface
 */
interface OrderManagerMiddlewareInterface
{
    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(OrderInterface $order, callable $next);
}
