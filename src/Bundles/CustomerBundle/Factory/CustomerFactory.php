<?php

namespace Bundles\CustomerBundle\Factory;

use Bundles\CustomerBundle\Model\ShopUser;
use Domain\Core\Urlizer;
use Domain\Customer\Command\CustomerCreateCommandInterface;
use Domain\Customer\Command\CustomerOauthRegistrationCommandInterface;
use Domain\Customer\Command\CustomerUpdateInfosCommandInterface;
use Domain\Customer\Signature\CustomerFactoryInterface;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

/**
 * Class CustomerFactory.
 */
class CustomerFactory implements CustomerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command): CustomerInterface
    {
        $username = $command->getUsername() ?: $command->getEmail()->getEmail();

        return ShopUser::create(
            $id,
            $command->getEmail(),
            Urlizer::urlize((string) $command->getEmail()),
            $command->getCivility(),
            $command->getFirstname(),
            $command->getLastname(),
            $username,
            $command->getPassword(),
            Urlizer::urlize($username)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function updateInfosFromCommand(CustomerUpdateInfosCommandInterface $command): CustomerInterface
    {
        $original = $command->getCustomer();
        $original->updateInfos(
            $command->getEmail(),
            Urlizer::urlize((string) $command->getEmail()),
            $command->getCivility(),
            $command->getLastname(),
            $command->getFirstname()
        );

        return $original;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(string $id, Email $email, ?Civility $civility = null): CustomerInterface
    {
        if (!$civility) {
            $civility = new Civility(Civility::DEFAULT);
        }

        return ShopUser::create($id, $email, Urlizer::urlize($email), $civility);
    }

    /**
     * {@inheritdoc}
     */
    public function createFromOauth(string $id, CustomerOauthRegistrationCommandInterface $command): CustomerInterface
    {
        return ShopUser::create(
            $id,
            $command->getEmail(),
            Urlizer::urlize((string) $command->getEmail()),
            new Civility(Civility::DEFAULT),
            $command->getFirstname(),
            $command->getLastname()
        );
    }
}
