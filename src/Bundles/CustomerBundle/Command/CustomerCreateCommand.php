<?php

namespace Bundles\CustomerBundle\Command;

use Domain\Customer\Command\CustomerCreateCommandHandler;
use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\ValueObject\Civility;

/**
 * Class CustomerCreateCommand.
 */
class CustomerCreateCommand implements CustomerCreateCommandInterface
{
    /**
     * @var Civility
     */
    private $civility;

    /**
     * @var string|null
     */
    private $firstname;

    /**
     * @var string|null
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * {@inheritdoc}
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstname(?string $firstname = ''): CustomerCreateCommandInterface
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastname(?string $lastname = ''): CustomerCreateCommandInterface
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email): CustomerCreateCommandInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername(?string $username = ''): CustomerCreateCommandInterface
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword(?string $password = ''): CustomerCreateCommandInterface
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return CustomerCreateCommandHandler::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getCivility(): Civility
    {
        return $this->civility;
    }

    /**
     * {@inheritdoc}
     */
    public function setCivility(Civility $civility): CustomerCreateCommandInterface
    {
        $this->civility = $civility;

        return $this;
    }
}
