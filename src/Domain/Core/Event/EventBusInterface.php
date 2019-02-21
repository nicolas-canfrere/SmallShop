<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 21/02/19
 * Time: 22:11
 */

namespace Domain\Core\Event;


interface EventBusInterface
{
    public function dispatch(EventInterface $event);
}