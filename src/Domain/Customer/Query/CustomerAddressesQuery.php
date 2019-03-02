<?php

namespace Domain\Customer\Query;

use Domain\Core\QueryBus\QueryInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerAddressesQuery
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
     * @return string
     */
    public function handleBy(): string
    {
        return CustomerAddressesQueryHandler::class;
    }
}
