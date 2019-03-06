<?php

namespace Domain\Customer\Event;

use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerRegistredFromOauthEvent.
 */
class CustomerRegistredFromOauthEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    protected $customer;
    /**
     * @var string
     */
    protected $client;

    /**
     * CustomerRegistredFromOauthEvent constructor.
     *
     * @param CustomerInterface $customer
     * @param string            $client
     */
    public function __construct(CustomerInterface $customer, string $client)
    {
        $this->customer = $customer;
        $this->client = $client;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->client;
    }
}
