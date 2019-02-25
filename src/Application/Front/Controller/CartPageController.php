<?php

namespace Application\Front\Controller;

use Domain\Cart\Signature\CartInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CartPageController.
 */
class CartPageController extends AbstractController
{
    /**
     * @param CartInterface $cart
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CartInterface $cart)
    {
        return $this->render('@front/CartPage/index.html.twig', ['cart' => $cart]);
    }
}
