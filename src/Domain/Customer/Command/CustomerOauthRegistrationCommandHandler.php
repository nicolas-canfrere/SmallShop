<?php

namespace Domain\Customer\Command;

use Bundles\CustomerBundle\Command\CustomerOauthRegistrationCommand;
use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBusInterface;
use Domain\Customer\Event\CustomerRegistredFromOauthEvent;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;

/**
 * Class CustomerOauthRegistrationCommandHandler.
 */
class CustomerOauthRegistrationCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var EventBusInterface
     */
    protected $eventBus;

    /**
     * @var CustomerFactoryInterface
     */
    protected $customerFactory;

    /**
     * CustomerOauthRegistrationCommandHandler constructor.
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerFactoryInterface    $customerFactory
     * @param EventBusInterface           $eventBus
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerFactoryInterface $customerFactory,
        EventBusInterface $eventBus
    ) {
        $this->customerRepository = $customerRepository;
        $this->eventBus = $eventBus;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param CommandInterface|CustomerOauthRegistrationCommand $command
     *
     * @return mixed
     */
    public function handle(CommandInterface $command)
    {
        $customer = $this->customerFactory->createFromOauth($this->customerRepository->nextIdentity(), $command);

        $this->customerRepository->save($customer);

        $event = new CustomerRegistredFromOauthEvent($customer, $command->getClient());

        $this->eventBus->dispatch($event);

        return $customer;
    }
}
