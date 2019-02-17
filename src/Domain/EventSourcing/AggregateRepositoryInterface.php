<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 22:08
 */

namespace Domain\EventSourcing;


interface AggregateRepositoryInterface
{
    public function save(AggregateInterface $aggregate);

    public function load($id): AggregateInterface;
}
