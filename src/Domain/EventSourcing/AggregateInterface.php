<?php

namespace Domain\EventSourcing;

interface AggregateInterface
{
    public function getId(): string;

    public function getUncommittedEvents(): EventStream;
}
