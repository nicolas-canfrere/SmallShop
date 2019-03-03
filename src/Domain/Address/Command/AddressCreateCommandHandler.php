<?php

namespace Domain\Address\Command;

use Domain\Address\AddressBook;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;

/**
 * Class AddressCreateCommandHandler.
 */
class AddressCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRespository;

    /**
     * @var EventBus
     */
    protected $evetBus;

    /**
     * AddressCreateCommandHandler constructor.
     *
     * @param AddressRepositoryInterface $addressRespository
     * @param EventBus                   $evetBus
     */
    public function __construct(AddressRepositoryInterface $addressRespository, EventBus $evetBus)
    {
        $this->addressRespository = $addressRespository;
        $this->evetBus = $evetBus;
    }

    /**
     * @param CommandInterface|AddressCreateCommandInterface $command
     *
     * @return mixed
     *
     * @throws \Domain\Address\Exception\AddressBookNewAddressNotCreated
     * @throws \Domain\Address\Exception\AddressBookNotLoadedException
     */
    public function handle(CommandInterface $command)
    {
        $addressBook = new AddressBook($this->addressRespository);
        $addressBook->load($command->getOwner());

        $addressBook->createNew();
        $addressBook->fillInWith(
            $command->getFullname(),
            $command->getStreet(),
            $command->getPostalCode(),
            $command->getCity(),
            $command->getCountry()
        );
        $addressBook->markNewAsDefaultDelivery();
    }
}
