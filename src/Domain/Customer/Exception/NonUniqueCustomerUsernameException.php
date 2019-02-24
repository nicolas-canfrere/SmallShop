<?php

namespace Domain\Customer\Exception;

class NonUniqueCustomerUsernameException extends \Exception
{
    protected $format = 'A customer with username \'%s\' already exists';

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->format, $message), $code, $previous);
    }
}
