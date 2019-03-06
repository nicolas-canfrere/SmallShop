<?php

namespace Domain\Customer;

use Domain\Customer\Signature\CustomerInterface;
use Domain\Customer\ValueObject\Civility;
use Domain\Customer\ValueObject\Email;

class Customer implements CustomerInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var Civility
     */
    protected $civility;

    /**
     * @var string|null
     */
    protected $firstname;

    /**
     * @var string|null
     */
    protected $lastname;

    /**
     * @var string|null
     */
    protected $username;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @var string
     */
    protected $canonicalEmail;

    /**
     * @var string|null
     */
    protected $canonicalUsername;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $plainPassword;

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
        $static = new static();

        $static->id = $id;
        $static->civility = $civility;
        $static->firstname = $firstname;
        $static->lastname = $lastname;
        $static->username = $username;
        $static->email = $email;
        $static->plainPassword = $password;
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
     * @return Civility
     */
    public function getCivility(): Civility
    {
        return $this->civility;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): Email
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
     * @return string|null
     */
    public function getCanonicalUsername(): ?string
    {
        return $this->canonicalUsername;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword(?string $password = ''): Customer
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function updateInfos(
        Email $email,
        string $canonicalEmail,
        Civility $civility,
        string $lastname,
        string $firstname
    ): CustomerInterface {
        $this->email = $email;
        $this->canonicalEmail = $canonicalEmail;
        $this->civility = $civility;
        $this->lastname = $lastname;
        $this->firstname = $firstname;

        return $this;
    }
}
