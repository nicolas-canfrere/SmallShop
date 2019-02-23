<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 09:54
 */

namespace Domain\Core\CommandBus;


interface CommandHandlerInterface
{
    public function handle(CommandInterface $command);
}