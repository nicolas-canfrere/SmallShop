<?php

namespace Tests\Domain\Customer\Command;

use Bundles\CustomerBundle\Command\CustomerCreateCommand;
use Bundles\CustomerBundle\Factory\CustomerFactory;
use Bundles\CustomerBundle\Model\ShopUser;
use Bundles\CustomerBundle\Repository\InMemoryCustomerRepository;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Event\EventListenerProvider;
use Domain\Core\Event\EventListenerProviderInterface;
use Domain\Core\Event\ListenerInterface;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandHandler;
use Domain\Customer\Event\CustomerCreatedEvent;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Exception\NonUniqueCustomerUsernameException;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Domain\Customer\ValueObject\Civility;
use PHPUnit\Framework\TestCase;

class CustomerCreateCommandHandlerTest extends TestCase
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var CustomerCreateCommandHandler
     */
    protected $handler;
    /**
     * @var EventListenerProviderInterface
     */
    protected $provider;
    /**
     * @var EventBusInterface
     */
    protected $eventBus;


    /**
     * @test
     */
    public function customerIsRegistred()
    {
        $username = 'username';

        $command = new CustomerCreateCommand();
        $command
            ->setUsername($username)
            ->setCivility(new Civility(Civility::DEFAULT))
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email@example.org')
            ->setPassword('password');

        $this->handler->handle($command);

        $customer = $this->customerRepository->oneByUsername($username);

        $this->assertInstanceOf(ShopUser::class, $customer);
    }

    /**
     * @test
     */
    public function mustThrowExceptionIfNonUniqueEmail()
    {
        $this->expectException(NonUniqueCustomerEmailException::class);
        $this->expectExceptionMessage('A customer with email \'email@example.org\' already exists');
        $this->customerRepository->save(
            $this->createCustomer('abc', 'firstname', 'lastname', 'username1', 'email@example.org'));
        $command = new CustomerCreateCommand();
        $command
            ->setUsername('username2')
            ->setCivility(new Civility(Civility::DEFAULT))
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email@example.org')
            ->setPassword('password');
        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function mustThrowExceptionIfNonUniqueUsername()
    {
        $this->expectException(NonUniqueCustomerUsernameException::class);
        $this->expectExceptionMessage('A customer with username \'username1\' already exists');
        $this->customerRepository->save(
            $this->createCustomer('abc', 'firstname', 'lastname', 'username1', 'email@example.org'));
        $command = new CustomerCreateCommand();
        $command
            ->setUsername('username1')
            ->setCivility(new Civility(Civility::DEFAULT))
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email2@example.org')
            ->setPassword('password');
        $this->handler->handle($command);
    }

    protected function createCustomer($id, $firstname, $lastname, $username, $email, $password = 'password')
    {
        $canonicalEmail = Urlizer::urlize($email);
        $canonicalUsername = Urlizer::urlize($username);
        $civility = new Civility(Civility::DEFAULT);

        return ShopUser::create($id, $email, $canonicalEmail, $civility, $firstname, $lastname, $username, $password, $canonicalUsername);
    }

    protected function setUp(): void
    {
        $this->customerRepository = new InMemoryCustomerRepository();
        $this->provider = new EventListenerProvider();
        $this->eventBus = new EventBus($this->provider);
        $this->handler = new CustomerCreateCommandHandler(
            new CustomerFactory(),
            $this->customerRepository,
            $this->eventBus
        );
    }

    /**
     * @test
     */
    public function emitCustomerCreatedEvent()
    {
        $listener = $this->getMockBuilder(ListenerInterface::class)
                         ->setMethods(['handle', 'listenTo'])
                         ->getMock();
        $listener->method('listenTo')->willReturn(CustomerCreatedEvent::class);
        $listener->expects($this->once())
                 ->method('handle')->with($this->isInstanceOf(CustomerCreatedEvent::class));

        $this->provider->addListener($listener);


        $command = new CustomerCreateCommand();
        $command
            ->setUsername('username')
            ->setCivility(new Civility(Civility::DEFAULT))
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email@example.org')
            ->setPassword('password');

        $this->handler->handle($command);
    }
}
