<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 10:55
 */

namespace Domain\Customer\Signature;


use Domain\Customer\Command\CustomerCreateCommandInterface;

interface CustomerFactoryInterface
{
    public function createFromCommand(string $id, CustomerCreateCommandInterface $command);
}