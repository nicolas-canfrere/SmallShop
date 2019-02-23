<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 10:00
 */

namespace Domain\Core\CommandBus;


interface CommandHandlerProviderInterface
{
    public function getHandlerForCommand(CommandInterface $command): CommandHandlerInterface;
}