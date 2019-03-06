<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandInterface;

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
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string|null
     */
    public function getLastname(): ?string;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string;
}
