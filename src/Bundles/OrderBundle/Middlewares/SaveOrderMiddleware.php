<?php

namespace Bundles\OrderBundle\Middlewares;


use Domain\Order\Signature\OrderFlowMiddlewareInterface;
use Domain\Order\Signature\OrderInterface;
use Domain\Order\Signature\OrderRepositoryInterface;

/**
 * Class SaveOrderMiddleware
 */
class SaveOrderMiddleware implements OrderFlowMiddlewareInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * SaveOrderMiddleware constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


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
