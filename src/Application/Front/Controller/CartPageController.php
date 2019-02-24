<?php

namespace Application\Front\Controller;

use Domain\Cart\Signature\CartInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartPageController extends AbstractController
{
    public function index(CartInterface $cart)
    {
        dump($cart);

        return $this->render('@front/CartPage/index.html.twig', ['cart' => $cart]);
    }
}
