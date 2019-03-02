<?php

namespace Domain\Address;

use Domain\Address\Signature\AddressInterface;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Customer\Signature\CustomerInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class AddressBook.
 */
final class AddressBook
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;
    /**
     * @var CustomerInterface
     */
    private $customer;
    /**
     * @var AddressInterface[]
     */
    private $addresses = [];
    /**
     * @var AddressInterface
     */
    private $newAddress;

    /**
     * AddressBook constructor.
     *
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function load(CustomerInterface $customer)
    {
        $this->customer = $customer;
        $this->addressRepository->getAllByCustomerId($this->customer->getId());
    }

    /**
     * @throws \Exception
     */
    public function createNew()
    {
        $this->newAddress = new Address(Uuid::uuid4()->toString());
        $this->newAddress->ownedBy($this->customer);
    }

    public function fillInWith(string $fullname, string $street, string $postalCode, string $city, string $country): void
    {
        $this->newAddress->fillInWith($fullname, $street, $postalCode, $city, $country);
    }


    public function markNewAsDefaultDelivery()
    {
        $this->newAddress->setAsDefaultDelivery();
        $currentDefaultDeliveryAddress = $this->retrieveDefaultDeliveryAddress();
        if ($currentDefaultDeliveryAddress) {
            $currentDefaultDeliveryAddress->unsetAsDefaultDelivery();
            $this->addressRepository->save($currentDefaultDeliveryAddress);
        }

        $this->addresses[] = $this->newAddress;
        $this->addressRepository->save($this->newAddress);
        $this->newAddress = null;
    }

    /**
     * @return AddressInterface|null
     */
    public function retrieveDefaultDeliveryAddress(): ?AddressInterface
    {
        foreach ($this->addresses as $address) {
            if ($address->isDelivery()) {
                return $address;
            }
        }

        return null;
    }
}
