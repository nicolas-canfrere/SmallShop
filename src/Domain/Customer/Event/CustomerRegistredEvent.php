<?php

namespace Domain\Customer\Event;

use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerRegistredEvent.
 */
final class CustomerRegistredEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    protected $customer;
    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * CustomerRegistredEvent constructor.
     *
     * @param CustomerInterface $customer
     *
     * @throws \Exception
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
