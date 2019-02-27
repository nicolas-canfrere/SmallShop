<?php

namespace Bundles\CustomerBundle\Factory;

use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerInterface;

/**
 * Class CustomerFactory.
 */
class CustomerFactory implements CustomerFactoryInterface
{
    /**
     * @param string                         $id
     * @param CustomerCreateCommandInterface $command
     *
     * @return CustomerInterface
     */
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command): CustomerInterface
    {
        $username = $command->getUsername() ?: $command->getEmail();

        return ShopUser::create(
            $id,
            $command->getEmail(),
            Urlizer::urlize($command->getEmail()),
            $command->getCivility(),
            $command->getFirstname(),
            $command->getLastname(),
            $username,
            $command->getPassword(),
            Urlizer::urlize($username)
        );
    }

    /**
     * @param CustomerUpdateInfosCommandInterface $command
     *
     * @return CustomerInterface
     */
    public function updateInfosFromCommand(CustomerUpdateInfosCommandInterface $command): CustomerInterface
    {
        $original = $command->getCustomer();
        $original->updateInfos(
            $command->getEmail(),
            Urlizer::urlize($command->getEmail()),
            $command->getCivility(),
            $command->getLastname(),
            $command->getFirstname()
        );

        return $original;
    }
}
