<?php

namespace Application\Front\Controller;


use Bundles\OrderBundle\Middlewares\Exception\CustomerNotLoggedInException;
use Bundles\OrderBundle\Middlewares\Exception\NoDeliveryAddressException;
use Domain\Order\Order;
use Domain\Order\OrderManager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function start(OrderManager $orderManager)
    {
        $order = Order::create('abc');
        try {
            $orderManager->handle($order);
        } catch (CustomerNotLoggedInException $e) {
            return $this->redirectToRoute('front_security_login');
        } catch (NoDeliveryAddressException $e) {
            return $this->redirectToRoute('front_customer_add_address');
        } catch (\Exception $e) {

        }


    }
}
