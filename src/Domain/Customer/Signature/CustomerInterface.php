<?php

namespace Domain\Customer\Signature;

use Domain\Core\Signature\EntityInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

/**
 * Interface CustomerInterface.
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
     * @return Email
     */
    public function getEmail(): Email;

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

    /**
     * @param Email   $email
     * @param string   $canonicalEmail
     * @param Civility $civility
     * @param string   $lastname
     * @param string   $firstname
     *
     * @return CustomerInterface
     */
    public function updateInfos(
        Email $email,
        string $canonicalEmail,
        Civility $civility,
        string $lastname,
        string $firstname
    ): CustomerInterface;
}
