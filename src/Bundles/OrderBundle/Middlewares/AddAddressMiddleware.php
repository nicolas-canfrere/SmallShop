<?php

namespace Bundles\OrderBundle\Middlewares;

use Bundles\OrderBundle\Middlewares\Exception\NoDeliveryAddressException;
use Domain\Address\AddressBook;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Order\Signature\OrderFlowMiddlewareInterface;
use Domain\Order\Signature\OrderInterface;

/**
 * Class AddAddressMiddleware
 * @package Bundles\OrderBundle\Middlewares
 */
class AddAddressMiddleware implements OrderFlowMiddlewareInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRespository;

    /**
     * AddAddressMiddleware constructor.
     *
     * @param AddressRepositoryInterface $addressRespository
     */
    public function __construct(AddressRepositoryInterface $addressRespository)
    {
        $this->addressRespository = $addressRespository;
    }


    /**
     * @param OrderInterface $order
     * @param callable $next
     *
     * @return mixed
     * @throws NoDeliveryAddressException
     */
    public function execute(OrderInterface $order, callable $next)
    {
        $customer = $order->getCustomer();
        $addressBook = new AddressBook($this->addressRespository);
        $addressBook->load($customer);

        $delivery = $addressBook->retrieveDefaultDeliveryAddress();

        if(!$delivery) {
            throw new NoDeliveryAddressException('no delivery address');
        }

        $order->setDeliveryAddress($addressBook->stringify($delivery));

        $billing = $addressBook->retrieveBillingAddress() ?: $delivery;

        $order->setBillingAddress($addressBook->stringify($billing));

        return $next($order);

    }
}
