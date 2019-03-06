<?php

namespace Bundles\CustomerBundle\Command;

use Domain\Customer\Command\CustomerUpdateInfosCommandHandler;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

class CustomerUpdateInfosCommand implements CustomerUpdateInfosCommandInterface
{
    /**
     * @var CustomerInterface
     */
    protected $customer;
    /**
     * @var Email
     */
    protected $email;
    /**
     * @var Civility
     */
    protected $civility;
    /**
     * @var string
     */
    protected $firstname;
    /**
     * @var string
     */
    protected $lastname;

    /**
     * CustomerUpdateInfosCommand constructor.
     *
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
        $this->email = $customer->getEmail();
        $this->civility = $customer->getCivility();
        $this->lastname = $customer->getLastname();
        $this->firstname = $customer->getFirstname();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomer(CustomerInterface $customer): CustomerUpdateInfosCommandInterface
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(Email $email): CustomerUpdateInfosCommandInterface
    {
        $this->email = $email;

        return $this;
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
    public function setCivility(Civility $civility): CustomerUpdateInfosCommandInterface
    {
        $this->civility = $civility;

        return $this;
    }

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
    public function setFirstname(?string $firstname = ''): CustomerUpdateInfosCommandInterface
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
    public function setLastname(?string $lastname = ''): CustomerUpdateInfosCommandInterface
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function handleBy(): string
    {
        return CustomerUpdateInfosCommandHandler::class;
    }
}
