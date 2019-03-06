<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;
use Domain\Customer\Event\CustomerInfosUpdatedEvent;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;

/**
 * Class CustomerUpdateInfosCommandHandler.
 */
class CustomerUpdateInfosCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var EventBus
     */
    protected $eventBus;
    /**
     * @var CustomerFactoryInterface
     */
    private $customerFactory;

    /**
     * CustomerUpdateInfosCommandHandler constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerFactoryInterface    $customerFactory
     * @param EventBus                    $eventBus
     */
    public function __construct(
        CustomerFactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        EventBus $eventBus
    ) {
        $this->customerRepository = $customerRepository;
        $this->eventBus = $eventBus;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param CommandInterface|CustomerUpdateInfosCommandInterface $command
     *
     * @return mixed
     *
     * @throws NonUniqueCustomerEmailException
     */
    public function handle(CommandInterface $command)
    {
        $original = $command->getCustomer();


        $testCustomer = $this->customerRepository->oneByEmail($command->getEmail());
        if ($testCustomer && $testCustomer->getId() !== $original->getId()) {
            throw new NonUniqueCustomerEmailException((string) $command->getEmail());
        }

        $original = $this->customerFactory->updateInfosFromCommand($command);

        $this->customerRepository->save($original);

        $this->eventBus->dispatch(new CustomerInfosUpdatedEvent($original));
    }
}
