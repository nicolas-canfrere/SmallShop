<?php

namespace Domain\Cart\Event;

use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CartClearEvent
 */
class CartClearEvent extends Event
{
    /**
     * @var CustomerInterface|null
     */
    protected $customer;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * CartClearEvent constructor.
     *
     * @param CustomerInterface|null $customer
     *
     * @throws \Exception
     */
    public function __construct(?CustomerInterface $customer)
    {
        $this->customer = $customer;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
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
