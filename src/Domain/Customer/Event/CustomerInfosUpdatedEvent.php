<?php

namespace Domain\Customer\Event;

use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerInfosUpdatedEvent.
 */
class CustomerInfosUpdatedEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * CustomerCreatedEvent constructor.
     *
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }
}
