<?php

namespace Domain\Customer\Signature;

use Domain\Customer\Command\CustomerCreateCommandInterface;

/**
 * Interface CustomerFactoryInterface
 */
interface CustomerFactoryInterface
{
    /**
     * @param string $id
     * @param CustomerCreateCommandInterface $command
     *
     * @return mixed
     */
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command);
}
