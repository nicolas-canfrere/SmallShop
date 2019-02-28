<?php

namespace Domain\Customer\Signature;

use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;
use Domain\Customer\ValueObject\Civility;

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

    /**
     * @param string        $id
     * @param string        $email
     * @param Civility|null $civility
     *
     * @return CustomerInterface
     */
    public function createNew(string $id, string $email, ?Civility $civility = null): CustomerInterface;
}
