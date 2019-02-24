<?php

namespace Domain\Customer\Exception;

use Throwable;

class NonUniqueCustomerEmailException extends \Exception
{
    protected $format = 'A customer with email \'%s\' already exists';

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->format, $message), $code, $previous);
    }
}
