<?php

namespace Bundles\CustomerBundle\Command;

use Domain\Customer\Command\CustomerOauthRegistrationCommandHandler;
use Domain\Customer\Command\CustomerOauthRegistrationCommandInterface;
use Domain\Customer\ValueObject\Email;

/**
 * Class CustomerOauthRegistrationCommand.
 */
class CustomerOauthRegistrationCommand implements CustomerOauthRegistrationCommandInterface
{
    /**
     * @var string
     */
    protected $client;
    /**
     * @var Email
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $lastname;

    /**
     * @var string|null
     */
    protected $firstname;

    /**
     * CustomerOauthRegistrationCommand constructor.
     *
     * @param Email       $email
     * @param string      $client
     * @param string|null $lastname
     * @param string|null $firstname
     */
    public function __construct(Email $email, string $client, ?string $lastname, ?string $firstname)
    {
        $this->email = $email;
        $this->client = $client;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
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
    public function getLastname(): ?string
    {
        return $this->lastname;
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
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function handleBy(): string
    {
        return CustomerOauthRegistrationCommandHandler::class;
    }
}
