<?php

namespace Tests\Bundles\CustomerBundle\Factory;

use Bundles\CustomerBundle\Command\CustomerCreateCommand;
use Bundles\CustomerBundle\Factory\CustomerFactory;
use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Customer\ValueObject\Civility;
use PHPUnit\Framework\TestCase;

class CustomerFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function isInstanceOfShopUser()
    {
        $command = new CustomerCreateCommand();
        $command
            ->setEmail('a')
            ->setCivility(new Civility(Civility::DEFAULT))
            ->setFirstname('a')
            ->setLastname('a')
            ->setUsername('a')
            ->setPassword('a');
        $shopuser = (new CustomerFactory())->createFromCommand('id', $command);

        $this->assertInstanceOf(ShopUser::class, $shopuser);
    }

    /**
     * @test
     */
    public function shopUserCanBeCreatedOnlyWithEmailAndId()
    {
        $command = new CustomerCreateCommand();
        $command
            ->setEmail('a')->setCivility(new Civility(Civility::DEFAULT));
        $shopuser = (new CustomerFactory())->createFromCommand('id', $command);

        $this->assertInstanceOf(ShopUser::class, $shopuser);
    }

    /**
     * @test
     */
    public function shopUserCannotBeCreatedWithoutEmailAndId()
    {
        $this->expectException(\TypeError::class);
        $command = new CustomerCreateCommand();
        $shopuser = (new CustomerFactory())->createFromCommand('id', $command);
    }

    /**
     * @test
     */
    public function ifUsernameIsEmptyPutEmailInstead()
    {
        $command = new CustomerCreateCommand();
        $command
            ->setEmail('abc@example.org')->setCivility(new Civility(Civility::DEFAULT));
        $shopuser = (new CustomerFactory())->createFromCommand('id', $command);

        $this->assertInstanceOf(ShopUser::class, $shopuser);
        $this->assertEquals('abc@example.org', $shopuser->getUsername());
        $this->assertEquals('abc-example-org', $shopuser->getCanonicalUsername());
    }
}
