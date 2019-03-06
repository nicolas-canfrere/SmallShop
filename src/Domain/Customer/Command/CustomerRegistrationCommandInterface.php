<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\ValueObject\Email;

/**
 * Class CustomerRegistrationCommandInterface.
 */
interface CustomerRegistrationCommandInterface extends CommandInterface
{
    /**
     * @return Email|null
     */
    public function getEmail(): ?Email;

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string;

    /**
     * @param Email|null $email
     *
     * @return CustomerRegistrationCommandInterface
     */
    public function setEmail(?Email $email = null): CustomerRegistrationCommandInterface;

    /**
     * @param string|null $plainPassword
     *
     * @return CustomerRegistrationCommandInterface
     */
    public function setPlainPassword(?string $plainPassword = ''): CustomerRegistrationCommandInterface;
}
