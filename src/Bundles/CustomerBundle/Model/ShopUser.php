<?php

namespace Bundles\CustomerBundle\Model;

use Domain\Customer\Customer;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ShopUser
 */
class ShopUser extends Customer implements UserInterface, \Serializable, EquatableInterface
{
    /**
     *
     */
    const ROLE = 'ROLE_CUSTOMER';

    /**
     * @var array
     */
    protected $roles = [ShopUser::ROLE];

    /**
     * @param string $id
     * @param string $email
     * @param string $canonicalEmail
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $username
     * @param string|null $password
     * @param string|null $canonicalUsername
     *
     * @return Customer
     */
    public static function create(
        string $id,
        string $email,
        string $canonicalEmail,
        ?string $firstname = '',
        ?string $lastname = '',
        ?string $username = '',
        ?string $password = '',
        ?string $canonicalUsername = ''
    ) {
        return parent::create(
            $id,
            $email,
            $canonicalEmail,
            $firstname,
            $lastname,
            $username,
            $password,
            $canonicalUsername
        );
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->email,
                $this->password,
            ]
        );
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if ($this->getPassword() !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->getEmail() !== $user->getEmail()) {
            return false;
        }

        return true;
    }
}
