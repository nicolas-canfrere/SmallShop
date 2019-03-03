<?php

namespace Tests\Domain\Address;


use Domain\Address\Address;
use Domain\Address\AddressBook;
use Domain\Address\Exception\AddressBookNewAddressNotCreated;
use Domain\Address\Exception\AddressBookNotLoadedException;
use Domain\Address\Repository\InMemoryAddressRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AddressBookTest extends TestCase
{
    /**
     * @var AddressBook
     */
    protected $addressBook;

    protected function setUp(): void
    {
        $this->addressBook = new AddressBook(new InMemoryAddressRepository());
    }


    /**
     * @test
     */
    public function insureIsLoadedBeforeCreateNew()
    {
        $this->expectException(AddressBookNotLoadedException::class);

        $this->addressBook->createNew();
    }

    /**
     * @test
     */
    public function insureNewAddressCreatedBeforeFillIn()
    {
        $this->expectException(AddressBookNewAddressNotCreated::class);

        $this->addressBook->fillInWith('a', 'b', 'c', 'd', 'e');
    }

    /**
     * @test
     */
    public function insureNewAddressCreatedBeforeMarkItAsDefaultDelivery()
    {
        $this->expectException(AddressBookNewAddressNotCreated::class);

        $this->addressBook->markNewAsDefaultDelivery();
    }

    /**
     * @test
     */
    public function addressAreSorted()
    {
        $this->addressBook
            ->addAddress($this->createAddress(false, true, 'name1'))
            ->addAddress($this->createAddress(false, false, 'name2'))
            ->addAddress($this->createAddress(true, false, 'name3'))
        ;

        $addresses = $this->addressBook->getAddresses();

        $this->assertCount(3, $addresses);
        $this->assertEquals('name3', $addresses[0]->getFullname());
        $this->assertEquals('name1', $addresses[1]->getFullname());
        $this->assertEquals('name2', $addresses[2]->getFullname());
        $this->assertEquals('name3', $this->addressBook->retrieveDefaultDeliveryAddress()->getFullname());
        $this->assertEquals('name1', $this->addressBook->retrieveBillingAddress()->getFullname());

        $this->addressBook->addAddress($this->createAddress(true, true, 'name4'));
        $addresses = $this->addressBook->getAddresses();
        $this->assertCount(4, $addresses);
        $this->assertEquals('name4', $addresses[0]->getFullname());
        $this->assertEquals('name3', $addresses[1]->getFullname());
        $this->assertEquals('name1', $addresses[2]->getFullname());
        $this->assertEquals('name2', $addresses[3]->getFullname());

        $this->assertEquals('name4', $this->addressBook->retrieveDefaultDeliveryAddress()->getFullname());
        $this->assertEquals('name4', $this->addressBook->retrieveBillingAddress()->getFullname());
    }

    private function createAddress(
        bool $isDelivery = false,
        bool $isBilling = false,
        string $fullname = 'fullname',
        string $street = 'street',
        string $postalCode = 'postalCode',
        string $city = 'city',
        string $country = 'country'
    ) {
        $address = new Address(Uuid::uuid4()->toString());
        $address->fillInWith(
            $fullname,
            $street,
            $postalCode,
            $city,
            $country
        );
        if($isDelivery) {
            $address->setAsDefaultDelivery();
        }
        if($isBilling) {
            $address->setAsDefaultBilling();
        }
        return $address;
    }
}
