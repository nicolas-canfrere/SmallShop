<?php

namespace Domain\Address;

use Domain\Address\Signature\AddressInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class Address.
 */
class Address implements AddressInterface
{
    /**
     * @var bool
     */
    protected $isDelivery = false;

    /**
     * @var bool
     */
    protected $isBilling = false;

    /**
     * @var string
     */
    protected $id;
    /**
     * @var CustomerInterface
     */
    protected $owner;
    /**
     * @var string
     */
    protected $fullname;
    /**
     * @var string
     */
    protected $street;
    /**
     * @var string
     */
    protected $postalCode;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $country;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return AddressInterface
     */
    public function ownedBy(CustomerInterface $customer): AddressInterface
    {
        $this->owner = $customer;

        return $this;
    }

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
    ): void {
        $this->fullname = $fullname;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
    }

    public function isOwnedBy(string $id): bool
    {
        return $this->owner->getId() === $id;
    }

    public function setAsDefaultDelivery(): void
    {
        $this->isDelivery = true;
    }

    public function unsetAsDefaultDelivery(): void
    {
        $this->isDelivery = false;
    }

    public function setAsDefaultBilling(): void
    {
        $this->isBilling = true;
    }

    public function unsetAsDefaultBilling(): void
    {
        $this->isBilling = false;
    }

    /**
     * {@inheritdoc}
     */
    public function isDelivery(): bool
    {
        return $this->isDelivery;
    }

    /**
     * {@inheritdoc}
     */
    public function isBilling(): bool
    {
        return $this->isBilling;
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return $this->fullname;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}
