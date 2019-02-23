<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 12:44
 */

namespace Domain\Customer\Exception;


use Throwable;

class NonUniqueCustomerEmailException extends \Exception
{
    protected $format = 'A customer with email \'%s\' already exists';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->format, $message), $code, $previous);
    }
}