<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 15:41
 */

namespace Domain\Customer\Event;


use Domain\Core\Event\Event;
use Domain\Customer\Signature\CustomerInterface;

class CustomerCreatedEvent extends Event
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * CustomerCreatedEvent constructor.
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