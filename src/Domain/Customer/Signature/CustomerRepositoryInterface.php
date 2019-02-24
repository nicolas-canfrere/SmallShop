<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\RepositoryInterface;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    public function oneByUsername(string $username): ?CustomerInterface;

    public function oneByEmail(string $email): ?CustomerInterface;
}
