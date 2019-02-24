<?php

namespace Application\Twig;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

/**
 * Class AppExtension.
 */
class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('format_price', [$this, 'formatPriceFilter']),
        ];
    }

    public function formatPriceFilter(Money $price, $iso = 'fr_FR')
    {
        $currencies      = new ISOCurrencies();
        $numberFormatter = new NumberFormatter($iso, NumberFormatter::CURRENCY);
        $moneyFormatter  = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($price);
    }
}
