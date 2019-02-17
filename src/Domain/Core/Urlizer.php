<?php

namespace Domain\Core;


use Behat\Transliterator\Transliterator;

/**
 * Class Urlizer
 * @package Domain\Core
 */
class Urlizer
{
    public static function urlize(string $string)
    {
        return Transliterator::urlize(Transliterator::transliterate($string));
    }
}
