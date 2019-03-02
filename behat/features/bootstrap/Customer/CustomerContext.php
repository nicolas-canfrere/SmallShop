<?php

namespace BehatTest\Customer;

use Behat\Behat\Context\Context;
use Bundles\CustomerBundle\Factory\CustomerFactory;
use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Address\AddressBook;
use Domain\Address\Repository\InMemoryAddressRepository;
use Domain\Address\Signature\AddressInterface;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\ValueObject\Civility;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class CustomerContext implements Context
{
    /**
     * @var AddressBook
     */
    protected $addressBook;
    /**
     * @var ShopUser;
     */
    protected $customer;
    /**
     * @var CustomerFactoryInterface
     */
    protected $customerFactory;
    /**
     * @var AddressInterface
     */
    protected $address;

    public function __construct()
    {
        $this->addressBook = new AddressBook(new InMemoryAddressRepository());
        $this->customerFactory = new CustomerFactory();
    }


    /**
     * @Given I am a registred customer
     */
    public function iAmARegistredCustomer()
    {
        $this->customer = $this->customerFactory->createNew(
            Uuid::uuid4()->toString(),
            'customer@example.org',
            new Civility(Civility::DEFAULT)
        );
    }

    /**
     * @When I add a new address to my address book
     */
    public function iAddANewAddressToMyAddressBook()
    {
        $this->addressBook->load($this->customer);
        $this->addressBook->createNew();
    }

    /**
     * @When I register :fullname, :street, :postalCode, :city, :country
     */
    public function iRegister($fullname, $street, $postalCode, $city, $country)
    {
        $this->addressBook->fillInWith($fullname, $street, $postalCode, $city, $country);
    }

    /**
     * @When I mark it as delivery address
     */
    public function iMarkItAsDeliveryAddress()
    {
        $this->addressBook->markNewAsDefaultDelivery();
    }

    /**
     * @Then address :fullname, :street, :postalCode, :city, :country should be my default address
     */
    public function addressShouldBeMyDefaultAddress($fullname, $street, $postalCode, $city, $country)
    {
        $defaultDeliveryAddress = $this->addressBook->retrieveDefaultDeliveryAddress();
        Assert::notNull($defaultDeliveryAddress);
        Assert::eq($fullname, $defaultDeliveryAddress->getFullname());
        Assert::eq($street, $defaultDeliveryAddress->getStreet());
        Assert::eq($postalCode, $defaultDeliveryAddress->getPostalCode());
        Assert::eq($city, $defaultDeliveryAddress->getCity());
        Assert::eq($country, $defaultDeliveryAddress->getCountry());
    }

}
