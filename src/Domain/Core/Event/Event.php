<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 21/02/19
 * Time: 23:57
 */

namespace Domain\Core\Event;


class Event implements EventInterface
{
    /**
     * @var bool
     */
    protected $stopPropagation;

    public function getName(): string
    {
        return get_class($this);
    }

    public function stopPropagation(bool $stop = false)
    {
        $this->stopPropagation = $stop;
    }

    public function isPropagationStopped(): bool
    {
        return $this->stopPropagation;
    }
}