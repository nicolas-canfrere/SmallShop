<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 10:29
 */

namespace Domain\Core\CommandBus;


interface CommandBusInterface
{
    public function handle(CommandInterface $command);
}