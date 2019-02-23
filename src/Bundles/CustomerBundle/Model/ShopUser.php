<?php

namespace Bundles\CustomerBundle\Model;

use Domain\Customer\Customer;
use Symfony\Component\Security\Core\User\UserInterface;

class ShopUser extends Customer implements UserInterface
{
    const ROLE = "ROLE_CUSTOMER";

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
    )
    {
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
        $this->password = '';
    }
}