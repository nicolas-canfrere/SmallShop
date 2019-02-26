<?php

namespace Domain\Core\Signature;


interface EqualInterface
{
    /**
     * @param $object
     *
     * @return bool
     */
    public function equals($object): bool;
}
