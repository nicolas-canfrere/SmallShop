<?php

namespace Tests\Domain\Address;


use Domain\Address\AddressBook;
use Domain\Address\Exception\AddressBookNewAddressNotCreated;
use Domain\Address\Exception\AddressBookNotLoadedException;
use Domain\Address\Repository\InMemoryAddressRepository;
use PHPUnit\Framework\TestCase;

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

        $this->addressBook->fillInWith('a','b', 'c','d', 'e');
    }

    /**
     * @test
     */
    public function insureNewAddressCreatedBeforeMarkItAsDefaultDelivery()
    {
        $this->expectException(AddressBookNewAddressNotCreated::class);

        $this->addressBook->markNewAsDefaultDelivery();
    }
}
