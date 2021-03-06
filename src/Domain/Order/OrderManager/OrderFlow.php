<?php

namespace Domain\Order\OrderManager;

use Domain\Order\Signature\OrderFlowInterface;
use Domain\Order\Signature\OrderInterface;

/**
 * Class OrderFlow
 */
class OrderFlow implements OrderFlowInterface
{


    /**
     * @var \Closure
     */
    protected $middlewareChain;

    /**
     * CommandBus constructor.
     *
     * @param array $middlewares
     */
    public function __construct($middlewares = [])
    {
        $this->middlewareChain = $this->createMiddlewareChain($middlewares);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(OrderInterface $order)
    {
        $middlewareChain = $this->middlewareChain;

        return $middlewareChain($order);
    }

    /**
     * @param array $middlewares
     *
     * @return \Closure
     */
    public function createMiddlewareChain($middlewares = []): \Closure
    {
        $next = function () {
        };
        while ($middleware = array_pop($middlewares)) {
            $next = function ($order) use ($middleware, $next) {
                return $middleware->execute($order, $next);
            };
        }

        return $next;
    }
}
