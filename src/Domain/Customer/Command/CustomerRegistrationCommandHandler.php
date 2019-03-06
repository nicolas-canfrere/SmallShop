<?php

namespace Domain\Customer\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBus;
use Domain\Customer\Event\CustomerRegistredEvent;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;

/**
 * Class CustomerRegistrationCommandHandler.
 */
class CustomerRegistrationCommandHandler implements CommandHandlerInterface
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
     * @param CommandInterface|CustomerRegistrationCommandInterface $command
     *
     * @return mixed
     *
     * @throws NonUniqueCustomerEmailException
     */
    public function handle(CommandInterface $command)
    {
        $customer = $this->customerRepository->oneByEmail($command->getEmail());

        if ($customer) {
            throw new NonUniqueCustomerEmailException(
                (string) $command->getEmail()
            );
        }

        $identity = $this->customerRepository->nextIdentity();

        $customer = $this->customerFactory->customerRegistration(
            $identity,
            $command->getEmail(),
            $command->getPlainPassword()
        );

        $this->customerRepository->save($customer);

        $this->eventBus->dispatch(new CustomerRegistredEvent($customer));

        return $customer;
    }
}
