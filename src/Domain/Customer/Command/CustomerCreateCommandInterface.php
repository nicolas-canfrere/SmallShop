<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\ValueObject\Civility;

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
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     *
     * @return CustomerCreateCommandInterface
     */
    public function setEmail(string $email): CustomerCreateCommandInterface;

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
