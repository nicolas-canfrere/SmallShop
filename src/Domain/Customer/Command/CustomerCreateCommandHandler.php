<?php

namespace Domain\Customer\Command;


use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
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
     * CustomerCreateCommandHandler constructor.
     * @param CustomerFactoryInterface $customerFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerFactoryInterface $customerFactory,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
    }


    /**
     * @param CommandInterface|CustomerCreateCommandInterface $command
     * @throws NonUniqueCustomerEmailException
     */
    public function handle(CommandInterface $command)
    {
        $customer = $this->customerRepository->oneByEmail($command->getEmail());

        if ($customer) {
            throw new NonUniqueCustomerEmailException(
                $command->getEmail()
            );
        }


        $identity = $this->customerRepository->nextIdentity();

        $customer = $this->customerFactory->createFromCommand($identity, $command);

        $this->customerRepository->save($customer);
    }
}