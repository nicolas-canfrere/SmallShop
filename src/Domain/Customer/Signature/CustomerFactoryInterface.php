<?php

namespace Domain\Customer\Signature;

use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Command\CustomerOauthRegistrationCommandInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

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
     * @param Email         $email
     * @param Civility|null $civility
     *
     * @return CustomerInterface
     */
    public function createNew(string $id, Email $email, ?Civility $civility = null): CustomerInterface;

    /**
     * @param string                                    $id
     * @param CustomerOauthRegistrationCommandInterface $command
     *
     * @return CustomerInterface
     */
    public function createFromOauth(string $id, CustomerOauthRegistrationCommandInterface $command): CustomerInterface;

    /**
     * @param $id
     * @param Email  $email
     * @param string $plainPassword
     *
     * @return CustomerInterface
     */
    public function customerRegistration(
        $id,
        Email $email,
        string $plainPassword
    ): CustomerInterface;
}
