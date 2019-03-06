<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\RepositoryInterface;
use Domain\Customer\ValueObject\Email;

/**
 * Interface CustomerRepositoryInterface.
 */
interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $username
     *
     * @return CustomerInterface|null
     */
    public function oneByUsername(string $username): ?CustomerInterface;

    /**
     * @param Email $email
     *
     * @return CustomerInterface|null
     */
    public function oneByEmail(Email $email): ?CustomerInterface;

    /**
     * @param string $username
     *
     * @return CustomerInterface|null
     */
    public function oneByUsernameOrEmail(string $username): ?CustomerInterface;
}
