<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 09:51
 */

namespace Domain\Core\CommandBus;


interface CommandInterface
{
    public function handleBy(): string;
}