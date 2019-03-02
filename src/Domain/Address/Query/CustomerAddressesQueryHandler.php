<?php

namespace Domain\Address\Query;

use Domain\Address\AddressBook;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\QueryBus\QueryInterface;

/**
 * Class CustomerAddressesQueryHandler.
 */
class CustomerAddressesQueryHandler implements QueryHandlerInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * CustomerAddressesQueryHandler constructor.
     *
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param QueryInterface|CustomerAddressesQuery $query
     *
     * @return AddressBook
     */
    public function handle(QueryInterface $query)
    {
        $addressBook = new AddressBook($this->addressRepository);
        $addressBook->load($query->getCustomer());

        return $addressBook;
    }
}
