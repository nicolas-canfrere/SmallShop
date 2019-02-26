<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\RepositoryInterface;

/**
 * Interface CustomerRepositoryInterface
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
     * @param string $email
     *
     * @return CustomerInterface|null
     */
    public function oneByEmail(string $email): ?CustomerInterface;

    /**
     * @param string $username
     *
     * @return CustomerInterface|null
     */
    public function oneByUsernameOrEmail(string $username): ?CustomerInterface;
}
