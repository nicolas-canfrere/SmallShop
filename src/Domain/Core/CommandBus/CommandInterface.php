<?php

namespace Domain\Core\CommandBus;

interface CommandInterface
{
    public function handleBy(): string;
}
