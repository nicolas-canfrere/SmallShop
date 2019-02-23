<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\EntityInterface;

interface CustomerInterface extends EntityInterface
{
    public function getFirstname(): string;

    public function getLastname(): string;

    public function getUsername(): string;

    public function getEmail(): string;

    public function getCanonicalEmail(): string;

    public function getCanonicalUsername(): string;

    public function getPassword(): string;
}
