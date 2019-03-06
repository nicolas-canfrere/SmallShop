<?php

namespace Bundles\CustomerBundle\Model;

use Domain\Customer\Customer;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ShopUser.
 */
class ShopUser extends Customer implements UserInterface, \Serializable, EquatableInterface
{
    const ROLE = 'ROLE_CUSTOMER';

    /**
     * @var array
     */
    protected $roles = [ShopUser::ROLE];

    /**
     * @param string      $id
     * @param Email      $email
     * @param string      $canonicalEmail
     * @param Civility    $civility
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
        Email $email,
        string $canonicalEmail,
        Civility $civility,
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
            $civility,
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
            $this->email,
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

        if (!$this->getEmail()->equals($user->getEmail())) {
            return false;
        }

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
