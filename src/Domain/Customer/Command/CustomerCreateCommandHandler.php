<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;
use Domain\Customer\Event\CustomerCreatedEvent;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Exception\NonUniqueCustomerUsernameException;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;

class CustomerCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerFactoryInterface
     */
    private $customerFactory;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * CustomerCreateCommandHandler constructor.
     *
     * @param CustomerFactoryInterface $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param EventBus $eventBus
     */
    public function __construct(
        CustomerFactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        EventBus $eventBus
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->eventBus = $eventBus;
    }

    /**
     * @param CommandInterface|CustomerCreateCommandInterface $command
     *
     * @throws NonUniqueCustomerEmailException
     * @throws NonUniqueCustomerUsernameException
     */
    public function handle(CommandInterface $command)
    {
        $customer = $this->customerRepository->oneByEmail($command->getEmail());

        if ($customer) {
            throw new NonUniqueCustomerEmailException(
                $command->getEmail()
            );
        }

        $customer = $this->customerRepository->oneByUsername($command->getUsername());

        if ($customer) {
            throw new NonUniqueCustomerUsernameException($command->getUsername());
        }

        $identity = $this->customerRepository->nextIdentity();

        $customer = $this->customerFactory->createFromCommand($identity, $command);

        $this->customerRepository->save($customer);

        $this->eventBus->dispatch(new CustomerCreatedEvent($customer));
    }
}
