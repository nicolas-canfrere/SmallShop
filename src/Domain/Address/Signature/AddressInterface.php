<?php

namespace Domain\Address\Signature;

use Domain\Core\Signature\EntityInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Interface AddressInterface.
 */
interface AddressInterface extends EntityInterface
{
    /**
     * @param CustomerInterface $customer
     *
     * @return AddressInterface
     */
    public function ownedBy(CustomerInterface $customer): AddressInterface;

    /**
     * @param string $fullname
     * @param string $street
     * @param string $postalCode
     * @param string $city
     * @param string $country
     */
    public function fillInWith(
        string $fullname,
        string $street,
        string $postalCode,
        string $city,
        string $country
    ): void;

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isOwnedBy(string $id): bool;

    public function setAsDefaultDelivery(): void;

    public function unsetAsDefaultDelivery(): void;

    /**
     * @return bool
     */
    public function isDelivery(): bool;

    /**
     * @return bool
     */
    public function isBilling(): bool;

    /**
     * @return string
     */
    public function getFullname(): string;

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @return string
     */
    public function getCountry(): string;
}
