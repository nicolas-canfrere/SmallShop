<?php

namespace Domain\Customer;


use Domain\Customer\Signature\CustomerInterface;

class Customer implements CustomerInterface
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $firstname;
    /**
     * @var string
     */
    protected $lastname;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $canonicalEmail;
    /**
     * @var string
     */
    protected $canonicalUsername;


}
