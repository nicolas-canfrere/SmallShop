<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 23/02/19
 * Time: 18:55
 */

namespace Domain\Core\CommandBus;


interface CommandBusMiddlewareInterface
{
    public function execute(CommandInterface $command, callable $next);
}