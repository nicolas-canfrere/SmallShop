<?php

namespace Domain\Address;

use Domain\Address\Exception\AddressBookNewAddressNotCreated;
use Domain\Address\Exception\AddressBookNotLoadedException;
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
     * @var bool
     */
    private $isLoaded = false;

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
        $this->addresses = $this->addressRepository->getAllByCustomerId($this->customer->getId());
        $this->sort();
        $this->isLoaded = true;
    }

    private function sort()
    {
        if (!$this->addresses) {
            return;
        }

        $addresses = $this->addresses;
        array_filter($addresses, function (AddressInterface $address) {
            return !$address->isDelivery() || !$address->isBilling();
        });

        $delivery = $this->retrieveDefaultDeliveryAddress();
        $billing = $this->retrieveBillingAddress();

        if ($billing && $billing !== $delivery) {
            array_unshift($addresses, $billing);
        }

        if ($delivery) {
            array_unshift($addresses, $delivery);
        }

        $this->addresses = $addresses;
    }

    /**
     * @throws AddressBookNotLoadedException
     */
    public function createNew()
    {
        if (!$this->isLoaded) {
            throw new AddressBookNotLoadedException();
        }
        $this->newAddress = new Address(Uuid::uuid4()->toString());
        $this->newAddress->ownedBy($this->customer);
    }

    /**
     * @param string $fullname
     * @param string $street
     * @param string $postalCode
     * @param string $city
     * @param string $country
     *
     * @throws AddressBookNewAddressNotCreated
     */
    public function fillInWith(string $fullname, string $street, string $postalCode, string $city, string $country): void
    {
        if (!$this->newAddress) {
            throw new AddressBookNewAddressNotCreated();
        }
        $this->newAddress->fillInWith($fullname, $street, $postalCode, $city, $country);
    }

    /**
     * @throws AddressBookNewAddressNotCreated
     */
    public function markNewAsDefaultDelivery()
    {
        if (!$this->newAddress) {
            throw new AddressBookNewAddressNotCreated();
        }
        $this->newAddress->setAsDefaultDelivery();
        $currentDefaultDeliveryAddress = $this->retrieveDefaultDeliveryAddress();
        if ($currentDefaultDeliveryAddress) {
            $currentDefaultDeliveryAddress->unsetAsDefaultDelivery();
            $this->addressRepository->save($currentDefaultDeliveryAddress);
        }
        $address = $this->newAddress;
        array_unshift($this->addresses, $address);
        $this->addressRepository->save($address);
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

    /**
     * @return AddressInterface|null
     */
    public function retrieveBillingAddress(): ?AddressInterface
    {
        foreach ($this->addresses as $address) {
            if ($address->isBilling()) {
                return $address;
            }
        }

        return null;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }
}
