<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

/**
 * Interface CustomerUpdateInfosCommandInterface.
 */
interface CustomerUpdateInfosCommandInterface extends CommandInterface
{
    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface;

    /**
     * @param CustomerInterface $customer
     *
     * @return CustomerUpdateInfosCommandInterface
     */
    public function setCustomer(CustomerInterface $customer): CustomerUpdateInfosCommandInterface;

    /**
     * @return Email
     */
    public function getEmail(): Email;

    /**
     * @param Email $email
     *
     * @return CustomerUpdateInfosCommandInterface
     */
    public function setEmail(Email $email): CustomerUpdateInfosCommandInterface;

    /**
     * @return Civility
     */
    public function getCivility(): Civility;

    /**
     * @param Civility $civility
     *
     * @return CustomerUpdateInfosCommandInterface
     */
    public function setCivility(Civility $civility): CustomerUpdateInfosCommandInterface;

    /**
     * @return string
     */
    public function getFirstname(): ?string;

    /**
     * @param string $firstname
     *
     * @return CustomerUpdateInfosCommandInterface
     */
    public function setFirstname(?string $firstname = ''): CustomerUpdateInfosCommandInterface;

    /**
     * @return string
     */
    public function getLastname(): ?string;

    /**
     * @param string $lastname
     *
     * @return CustomerUpdateInfosCommandInterface
     */
    public function setLastname(?string $lastname = ''): CustomerUpdateInfosCommandInterface;
}
