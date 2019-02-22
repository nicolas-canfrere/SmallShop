<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:36
 */

namespace Application\DataFixtures;


use Bundles\ProductBundle\Command\ProductCreateCommand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Product\ValueObject\ProductName;
use League\Tactician\CommandBus;
use Money\Currency;
use Money\Money;

class ProductFixture extends Fixture
{

    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {

        $this->commandBus = $commandBus;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i < 51; $i++) {
            $command              = new ProductCreateCommand();
            $command->setName(new ProductName($faker->words(2, true)));
            $command->setPrice(new Money(rand(10, 500) * 100, new Currency('EUR')));
            $command->setDescription('<p>' . implode('</p><p>', $faker->sentences()) . '</p>');
            $this->commandBus->handle($command);
        }
    }
}
