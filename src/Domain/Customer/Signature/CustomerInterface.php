<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\EntityInterface;
use Domain\Customer\ValueObject\Civility;

/**
 * Interface CustomerInterface
 */
interface CustomerInterface extends EntityInterface
{
    /**
     * @return Civility
     */
    public function getCivility(): Civility;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string;

    /**
     * @return string|null
     */
    public function getLastname(): ?string;

    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getCanonicalEmail(): string;

    /**
     * @return string|null
     */
    public function getCanonicalUsername(): ?string;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;
}
