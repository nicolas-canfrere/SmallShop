<?php

namespace Tests\Domain\Customer\Command;


use Bundles\CustomerBundle\Command\CustomerUpdateInfosCommand;
use Bundles\CustomerBundle\Factory\CustomerFactory;
use Bundles\CustomerBundle\Repository\InMemoryCustomerRepository;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Event\EventListenerProvider;
use Domain\Core\Event\EventListenerProviderInterface;
use Domain\Core\Event\ListenerInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandHandler;
use Domain\Customer\Event\CustomerInfosUpdatedEvent;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Domain\Customer\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class CustomerUpdateInfosCommandHandlerTest extends TestCase
{

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var CustomerUpdateInfosCommandHandler
     */
    protected $handler;
    /**
     * @var CustomerFactoryInterface
     */
    protected $customerFactory;
    /**
     * @var EventListenerProviderInterface
     */
    protected $provider;
    /**
     * @var EventBusInterface
     */
    protected $eventBus;

    protected function setUp():void
    {
        $this->customerRepository = new InMemoryCustomerRepository();

        $this->customerFactory = new CustomerFactory();

        $this->provider = new EventListenerProvider();
        $this->eventBus = new EventBus($this->provider);

        $this->handler = new CustomerUpdateInfosCommandHandler(
            $this->customerFactory,
            $this->customerRepository,
            $this->eventBus
        );
    }


    /**
     * @test
     */
    public function mustThrowExceptionIfEmailExistsInOtherCustomer()
    {
        $this->expectException(NonUniqueCustomerEmailException::class);

        $uniqueEmail = new Email('email_2@example.org');
        $customerToUpdate = $this->customerFactory->createNew('identity1', new Email('email_1@example.org'));
        $otherCustomer = $this->customerFactory->createNew('identity2', $uniqueEmail);
        $this->customerRepository->save($customerToUpdate);
        $this->customerRepository->save($otherCustomer);

        $command = new CustomerUpdateInfosCommand($customerToUpdate);
        $command->setEmail($uniqueEmail);

        $this->handler->handle($command);

    }

    /**
     * @test
     */
    public function updateWithoutChangingEmailMustPass()
    {
        $firstname = 'firstname_after';
        $customerToUpdate = $this->customerFactory->createNew('identity1', new Email('email_1@example.org'));
        $this->customerRepository->save($customerToUpdate);
        $command = new CustomerUpdateInfosCommand($customerToUpdate);
        $command->setFirstname($firstname);
        $this->handler->handle($command);

        $this->assertEquals($firstname, $customerToUpdate->getFirstname());
    }

    /**
     * @test
     */
    public function emitCustomerInfosUpdatedEvent()
    {
        $listener = $this->getMockBuilder(ListenerInterface::class)
                         ->setMethods(['handle', 'listenTo'])
                         ->getMock();
        $listener->method('listenTo')->willReturn(CustomerInfosUpdatedEvent::class);
        $listener->expects($this->once())
                 ->method('handle')->with($this->isInstanceOf(CustomerInfosUpdatedEvent::class));

        $this->provider->addListener($listener);
        $customerToUpdate = $this->customerFactory->createNew('identity1', new Email('email_1@example.org'));
        $this->customerRepository->save($customerToUpdate);
        $command = new CustomerUpdateInfosCommand($customerToUpdate);
        $this->handler->handle($command);
    }


}
