<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\ValueObject\Email;

/**
 * Class CustomerOauthRegistrationCommandInterface.
 */
interface CustomerOauthRegistrationCommandInterface extends CommandInterface
{
    /**
     * @return string
     */
    public function getClient(): string;

    /**
     * @return Email
     */
    public function getEmail(): Email;

    /**
     * @return string|null
     */
    public function getLastname(): ?string;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string;
}
