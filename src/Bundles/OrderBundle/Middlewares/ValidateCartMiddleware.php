<?php

namespace Bundles\OrderBundle\Middlewares;


use Domain\Order\Signature\OrderFlowMiddlewareInterface;
use Domain\Order\Signature\OrderInterface;

/**
 * Class VerifyCartMiddleware
 */
class ValidateCartMiddleware implements OrderFlowMiddlewareInterface
{

    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(OrderInterface $order, callable $next)
    {
        return $next($order);
    }
}
