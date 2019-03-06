<?php

namespace Domain\Customer\ValueObject;

use Domain\Core\Signature\EqualInterface;

/**
 * Class Email.
 */
final class Email implements EqualInterface, \Serializable
{
    private $email;

    /**
     * Email constructor.
     *
     * @param $email
     */
    public function __construct(string $email)
    {
        $this->email = $this->validate($this->sanitize($email));
    }

    public function sanitize(string $email)
    {
        $email = trim($email);
        if (function_exists('mb_strtolower')) {
            $email = mb_strtolower($email, 'UTF-8');
        } else {
            $email = strtolower($email);
        }

        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    public function validate(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('email ivalid!');
        }

        return $email;
    }

    /**
     * @param Email $object
     *
     * @return bool
     */
    public function equals($object): bool
    {
        return $this->email === $object->getEmail();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString()
    {
        return $this->email;
    }

    public function serialize()
    {
        return serialize($this->email);
    }

    public function unserialize($serialized)
    {
        $this->email = unserialize($serialized);
    }


}
