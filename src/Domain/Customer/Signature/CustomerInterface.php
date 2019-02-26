<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\EntityInterface;

/**
 * Interface CustomerInterface
 */
interface CustomerInterface extends EntityInterface
{
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
