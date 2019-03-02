<?php

namespace Domain\Address\Query;

use Domain\Core\QueryBus\QueryInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerAddressesQuery.
 */
class CustomerAddressesQuery implements QueryInterface
{
    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * CustomerAddressesQuery constructor.
     *
     * @param $customer
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

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return CustomerAddressesQueryHandler::class;
    }
}
