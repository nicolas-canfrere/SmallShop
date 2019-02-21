<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 22/02/19
 * Time: 00:14
 */

namespace Domain\Tests\Core\Event;


use Domain\Core\Event\Event;

final class TestEventTwo extends Event
{
    public function isPropagationStopped(): bool
    {
        return true;
    }
}