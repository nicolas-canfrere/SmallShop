<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 25/02/19
 * Time: 20:26
 */

namespace Bundles\CustomerBundle\Doctrine;


use Bundles\CustomerBundle\Model\ShopUser;
use Bundles\CustomerBundle\Repository\ShopUserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ShopUserProvider implements UserProviderInterface
{

    /**
     * @var ShopUserRepository
     */
    private $customerRepository;

    public function __construct(ShopUserRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param string $username
     *
     * @return \Domain\Customer\Signature\CustomerInterface|UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        $customer = $this->customerRepository->oneByUsernameOrEmail($username);

        if ($customer) {
            return $customer;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    /**
     * @param UserInterface $user
     *
     * @return \Domain\Customer\Signature\CustomerInterface|UserInterface|null
     */
    public function refreshUser(UserInterface $user)
    {
        if ( ! $user instanceof ShopUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return ShopUser::class === $class;
    }
}
