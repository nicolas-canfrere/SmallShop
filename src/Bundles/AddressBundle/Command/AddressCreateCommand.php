<?php

namespace Bundles\AddressBundle\Command;

use Domain\Address\Command\AddressCreateCommandHandler;
use Domain\Address\Command\AddressCreateCommandInterface;
use Domain\Customer\Signature\CustomerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AddressCreateCommand.
 */
class AddressCreateCommand implements AddressCreateCommandInterface
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="required")
     */
    protected $fullname;
    /**
     * @var string|null
     * @Assert\NotBlank(message="required")
     */
    protected $street;
    /**
     * @var string|null
     * @Assert\NotBlank(message="required")
     */
    protected $postalCode;
    /**
     * @var string|null
     * @Assert\NotBlank(message="required")
     */
    protected $city;
    /**
     * @var string|null
     * @Assert\NotBlank(message="required")
     */
    protected $country;
    /**
     * @var CustomerInterface
     */
    protected $owner;

    /**
     * AddressCreateCommand constructor.
     *
     * @param CustomerInterface $owner
     */
    public function __construct(CustomerInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string|null $fullname
     *
     * @return AddressCreateCommand
     */
    public function setFullname(?string $fullname): AddressCreateCommand
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return AddressCreateCommand
     */
    public function setStreet(?string $street): AddressCreateCommand
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return AddressCreateCommand
     */
    public function setPostalCode(?string $postalCode): AddressCreateCommand
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return AddressCreateCommand
     */
    public function setCity(?string $city): AddressCreateCommand
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return AddressCreateCommand
     */
    public function setCountry(?string $country): AddressCreateCommand
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return CustomerInterface
     */
    public function getOwner(): CustomerInterface
    {
        return $this->owner;
    }

    /**
     * @param CustomerInterface $owner
     *
     * @return AddressCreateCommand
     */
    public function setOwner(CustomerInterface $owner): AddressCreateCommand
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string
     */
    public function handleBy(): string
    {
        return AddressCreateCommandHandler::class;
    }
}
