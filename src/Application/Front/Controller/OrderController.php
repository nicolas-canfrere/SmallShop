<?php

namespace Application\Front\Controller;


use Bundles\OrderBundle\Service\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function index(OrderManager $orderManager)
    {
        return $orderManager();
    }
}
