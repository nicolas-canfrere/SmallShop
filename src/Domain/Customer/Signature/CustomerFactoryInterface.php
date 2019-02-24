<?php

namespace Domain\Customer\Signature;

use Domain\Customer\Command\CustomerCreateCommandInterface;

interface CustomerFactoryInterface
{
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command);
}
