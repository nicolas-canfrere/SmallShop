<?php

namespace Application\Twig;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AppExtension.
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('format_price', [$this, 'formatPriceFilter']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('lang_switch', [$this, 'langSwitch'], ['is_safe'=>['html']]),
        ];
    }


    public function formatPriceFilter(Money $price, $iso = 'fr_FR')
    {
        $currencies = new ISOCurrencies();
        $numberFormatter = new NumberFormatter($iso, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($price);
    }

    public function langSwitch(string $locale = 'fr')
    {
        $allowedLangs = ['fr', 'en'];
        $locale = in_array($locale, $allowedLangs) ? $locale :'fr';
        $locale = array_values(array_diff($allowedLangs, [$locale]))[0];
        $url = $this->router->generate('front_home', ['_locale'=>$locale]);
        $link = sprintf('<a href="%s" class="nav-link"><i class="fas fa-flag"></i> %s</a>', $url, strtoupper($locale));

        return $link;
    }
}
