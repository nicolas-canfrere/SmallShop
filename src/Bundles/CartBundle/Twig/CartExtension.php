<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 18:45
 */

namespace Bundles\CartBundle\Twig;


use Domain\Cart\Signature\CartInterface;

class CartExtension extends \Twig_Extension
{
    /**
     * @var CartInterface
     */
    private $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cart_counter', [$this, 'cartCounter']),
        ];
    }

    public function cartCounter()
    {
        return $this->cart->count();
    }


}
