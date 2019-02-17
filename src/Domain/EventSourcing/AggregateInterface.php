<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 22:07
 */

namespace Domain\EventSourcing;


interface AggregateInterface
{
    public function getId(): string;

    public function getUncommittedEvents(): EventStream;
}
