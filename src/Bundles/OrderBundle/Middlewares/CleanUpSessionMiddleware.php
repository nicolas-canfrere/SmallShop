<?php

namespace Bundles\OrderBundle\Middlewares;


use Domain\Order\Signature\OrderFlowMiddlewareInterface;
use Domain\Order\Signature\OrderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CleanUpSessionMiddleware
 */
class CleanUpSessionMiddleware implements OrderFlowMiddlewareInterface
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * CleanUpSessionMiddleware constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     */
    public function execute(OrderInterface $order, callable $next)
    {
        if($this->session->has('order')) {
            $this->session->remove('order');
        }
        return $order;
    }
}
