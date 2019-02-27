<?php

namespace Domain\Customer\Signature;

use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;

/**
 * Interface CustomerFactoryInterface.
 */
interface CustomerFactoryInterface
{
    /**
     * @param string                         $id
     * @param CustomerCreateCommandInterface $command
     *
     * @return CustomerInterface
     */
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command): CustomerInterface;

    /**
     * @param CustomerUpdateInfosCommandInterface $command
     *
     * @return CustomerInterface
     */
    public function updateInfosFromCommand(CustomerUpdateInfosCommandInterface $command): CustomerInterface;
}
