<?php

namespace Bundles\CustomerBundle\Factory;

use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Exception\CustomerMissingEmailOrIdException;
use Domain\Customer\Signature\CustomerFactoryInterface;

/**
 * Class CustomerFactory
 */
class CustomerFactory implements CustomerFactoryInterface
{
    /**
     * @param string $id
     * @param CustomerCreateCommandInterface $command
     *
     * @return \Domain\Customer\Customer|mixed
     */
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command)
    {

        return ShopUser::create(
            $id,
            $command->getEmail(),
            Urlizer::urlize($command->getEmail()),
            $command->getFirstname(),
            $command->getLastname(),
            $command->getUsername(),
            $command->getPassword(),
            Urlizer::urlize($command->getUsername())
        );
    }
}
