<?php

namespace Domain\Tests\Customer\Command;


use Bundles\CustomerBundle\Command\CustomerCreateCommand;
use Bundles\CustomerBundle\Factory\CustomerFactory;
use Bundles\CustomerBundle\Model\ShopUser;
use Bundles\CustomerBundle\Repository\InMemoryCustomerRepository;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventListenerProvider;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandHandler;
use Domain\Customer\Exception\NonUniqueCustomerEmailException;
use Domain\Customer\Exception\NonUniqueCustomerUsernameException;
use Domain\Customer\Signature\CustomerRepositoryInterface;
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
     * @test
     */
    public function customerIsRegistred()
    {
        $username = 'username';

        $command = new CustomerCreateCommand();
        $command
            ->setUsername($username)
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

        return ShopUser::create($id, $firstname, $lastname, $username, $email, $password, $canonicalUsername, $canonicalEmail);
    }

    protected function setUp(): void
    {
        $this->customerRepository = new InMemoryCustomerRepository();

        $this->handler = new CustomerCreateCommandHandler(
            new CustomerFactory(),
            $this->customerRepository,
            $eventBus = new EventBus(new EventListenerProvider())
        );
    }
}