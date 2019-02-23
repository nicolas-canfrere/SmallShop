<?php

namespace Bundles\CustomerBundle\Command;


use Domain\Customer\Command\CustomerCreateCommandHandler;
use Domain\Customer\Command\CustomerCreateCommandInterface;

class CustomerCreateCommand implements CustomerCreateCommandInterface
{
    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return CustomerCreateCommand
     */
    public function setFirstname(string $firstname): CustomerCreateCommandInterface
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return CustomerCreateCommand
     */
    public function setLastname(string $lastname): CustomerCreateCommandInterface
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CustomerCreateCommand
     */
    public function setEmail(string $email): CustomerCreateCommandInterface
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return CustomerCreateCommand
     */
    public function setUsername(string $username): CustomerCreateCommandInterface
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return CustomerCreateCommand
     */
    public function setPassword(string $password): CustomerCreateCommandInterface
    {
        $this->password = $password;
        return $this;
    }

    public function handleBy(): string
    {
        return CustomerCreateCommandHandler::class;
    }
}