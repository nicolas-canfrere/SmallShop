<?php

namespace Bundles\OrderBundle\Middlewares;


use Bundles\OrderBundle\Middlewares\Exception\CustomerNotLoggedInException;
use Domain\Order\Signature\OrderInterface;
use Domain\Order\Signature\OrderManagerMiddlewareInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomerIsLoggedMiddleware implements OrderManagerMiddlewareInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * CustomerIsLoggedMiddleware constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     * @throws CustomerNotLoggedInException
     */
    public function execute(OrderInterface $order, callable $next)
    {
        $token = $this->tokenStorage->getToken();

        if(null === $token || !\is_object($user = $token->getUser())) {
            // do something ...
            throw new CustomerNotLoggedInException('user not logged in');
        }

        $order->setCustomer($user);

        return $next($order);
    }
}
