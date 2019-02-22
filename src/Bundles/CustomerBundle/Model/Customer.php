<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 22/02/19
 * Time: 09:35
 */

namespace Bundles\CustomerBundle\Model;

use Domain\Customer\Customer as BaseCustomer;
use Symfony\Component\Security\Core\User\UserInterface;

class Customer extends BaseCustomer implements UserInterface
{
    const ROLE = "ROLE_CUSTOMER";

    protected $roles = [Customer::ROLE];

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