<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 11:40
 */

namespace Application\Front\Controller;


use Domain\Cart\Signature\CartInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartPageController extends AbstractController
{
    public function index(CartInterface $cart)
    {
        return $this->render('@front/CartPage/index.html.twig', ['cart' => $cart]);
    }
}
