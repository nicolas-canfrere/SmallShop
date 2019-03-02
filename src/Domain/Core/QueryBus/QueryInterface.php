<?php

namespace Domain\Core\QueryBus;

/**
 * Interface QueryInterface.
 */
interface QueryInterface
{
    /**
     * @return string
     */
    public function handleBy(): string;
}
