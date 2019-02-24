<?php

namespace Domain\EventSourcing;

interface AggregateRepositoryInterface
{
    public function save(AggregateInterface $aggregate);

    public function load($id): AggregateInterface;
}
