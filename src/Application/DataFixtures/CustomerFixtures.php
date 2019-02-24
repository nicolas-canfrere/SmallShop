<?php

namespace Application\DataFixtures;

use Bundles\CustomerBundle\Command\CustomerCreateCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Core\CommandBus\CommandBusInterface;

class CustomerFixtures extends Fixture
{
    /**
     * @var CommandBusInterface
     */
    protected $commandBus;

    /**
     * CustomerFixtures constructor.
     *
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; ++$i) {
            $command = new CustomerCreateCommand();
            $command
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->safeEmail)
                ->setUsername('username_'.$i)
                ->setPassword('password_'.$i);
            $this->commandBus->handle($command);
        }
    }
}
