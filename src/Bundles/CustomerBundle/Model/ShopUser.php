<?php

namespace Bundles\CustomerBundle\Model;

use Domain\Customer\Customer;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ShopUser extends Customer implements UserInterface, \Serializable, EquatableInterface
{
    const ROLE = 'ROLE_CUSTOMER';

    protected $roles = [ShopUser::ROLE];

    public static function create(
        string $id,
        string $firstname,
        string $lastname,
        string $username,
        string $email,
        string $password,
        string $canonicalUsername,
        string $canonicalEmail
    ) {
        return parent::create(
            $id,
            $firstname,
            $lastname,
            $username,
            $email,
            $password,
            $canonicalUsername,
            $canonicalEmail
        );
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

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
                $this->username,
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
            $this->username,
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

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
