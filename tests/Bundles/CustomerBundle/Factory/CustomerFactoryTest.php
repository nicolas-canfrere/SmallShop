<?php

namespace Bundles\CustomerBundle\Factory;

use Bundles\CustomerBundle\Command\CustomerCreateCommand;
use Bundles\CustomerBundle\Model\ShopUser;
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
            ->setFirstname('a')
            ->setLastname('a')
            ->setUsername('a')
            ->setPassword('a');
        $shopuser = (new CustomerFactory)->createFromCommand('id', $command);

        $this->assertInstanceOf(ShopUser::class, $shopuser);
    }
}
