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
    /**
     * @var string
     */
    protected $password;

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
        $static = new static();

        $static->id = $id;
        $static->firstname = $firstname;
        $static->lastname = $lastname;
        $static->username = $username;
        $static->email = $email;
        $static->password = $password;
        $static->canonicalUsername = $canonicalUsername;
        $static->canonicalEmail = $canonicalEmail;

        return $static;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCanonicalEmail(): string
    {
        return $this->canonicalEmail;
    }

    /**
     * @return string
     */
    public function getCanonicalUsername(): string
    {
        return $this->canonicalUsername;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
