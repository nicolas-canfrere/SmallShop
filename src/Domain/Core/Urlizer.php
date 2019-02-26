<?php

namespace Domain\Core;

use Behat\Transliterator\Transliterator;

/**
 * Class Urlizer.
 */
class Urlizer
{
    /**
     * @param string|null $string
     *
     * @return string
     */
    public static function urlize(?string $string = '')
    {
        if (!$string) {
            return '';
        }

        return Transliterator::urlize(Transliterator::transliterate($string));
    }
}
