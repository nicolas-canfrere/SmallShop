<?php

namespace Domain\Core\CommandBus;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    /**
     * @return string
     */
    public function handleBy(): string;
}
