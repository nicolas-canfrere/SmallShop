<?php

namespace Bundles\CustomerBundle\Factory;


use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Signature\CustomerFactoryInterface;

class CustomerFactory implements CustomerFactoryInterface
{

    public function createFromCommand(string $id, CustomerCreateCommandInterface $command)
    {
        return ShopUser::create(
            $id,
            $command->getFirstname(),
            $command->getLastname(),
            $command->getUsername(),
            $command->getEmail(),
            $command->getPassword(),
            Urlizer::urlize($command->getUsername()),
            Urlizer::urlize($command->getEmail())
        );
    }
}