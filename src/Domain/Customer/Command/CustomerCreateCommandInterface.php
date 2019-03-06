<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

/**
 * Interface CustomerCreateCommandInterface.
 */
interface CustomerCreateCommandInterface extends CommandInterface
{
    /**
     * @return Civility
     */
    public function getCivility(): Civility;

    /**
     * @param Civility $civility
     *
     * @return $this
     */
    public function setCivility(Civility $civility): CustomerCreateCommandInterface;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string;

    /**
     * @param string|null $firstname
     *
     * @return CustomerCreateCommandInterface
     */
    public function setFirstname(?string $firstname = ''): CustomerCreateCommandInterface;

    /**
     * @return string|null
     */
    public function getLastname(): ?string;

    /**
     * @param string|null $lastname
     *
     * @return CustomerCreateCommandInterface
     */
    public function setLastname(?string $lastname = ''): CustomerCreateCommandInterface;

    /**
     * @return Email
     */
    public function getEmail(): Email;

    /**
     * @param Email $email
     *
     * @return CustomerCreateCommandInterface
     */
    public function setEmail(Email $email): CustomerCreateCommandInterface;

    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @param string|null $username
     *
     * @return CustomerCreateCommandInterface
     */
    public function setUsername(?string $username = ''): CustomerCreateCommandInterface;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * @param string|null $password
     *
     * @return CustomerCreateCommandInterface
     */
    public function setPassword(?string $password = ''): CustomerCreateCommandInterface;
}
