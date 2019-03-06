<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 06/03/19
 * Time: 23:03.
 */

namespace Bundles\CustomerBundle\Command;

use Domain\Customer\Command\CustomerRegistrationCommandHandler;
use Domain\Customer\Command\CustomerRegistrationCommandInterface;
use Domain\Customer\ValueObject\Email;

class CustomerRegistrationCommand implements CustomerRegistrationCommandInterface
{
    /**
     * @var Email|null
     */
    protected $email;
    /**
     * @var string|null
     */
    protected $plainPassword;

    /**
     * CustomerRegistrationCommand constructor.
     *
     * @param Email  $email
     * @param string $plainPassword
     */
    public function __construct(?Email $email = null, ?string $plainPassword = null)
    {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param Email|null $email
     *
     * @return CustomerRegistrationCommandInterface
     */
    public function setEmail(?Email $email = null): CustomerRegistrationCommandInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return CustomerRegistrationCommandInterface
     */
    public function setPlainPassword(?string $plainPassword = ''): CustomerRegistrationCommandInterface
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return CustomerRegistrationCommandHandler::class;
    }
}
