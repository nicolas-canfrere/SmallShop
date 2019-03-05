<?php

namespace Application\Front\Controller;

use Bundles\CartBundle\Command\AddProductToCartCommand;
use Bundles\CartBundle\Command\ClearCartCommand;
use Bundles\CartBundle\Command\RemoveProductFromCartCommand;
use Domain\Core\CommandBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CartController.
 */
class CartController extends AbstractController
{
    public function addToCart(Request $request, CommandBus $commandBus)
    {
        $params = $request->request->all();
        $params['customer'] = $this->getUser();
        $addToCartCommand = AddProductToCartCommand::fromArray($params);
        try {
            $commandBus->handle($addToCartCommand);
        } catch (\Exception $e) {
        }

        return $this->redirectToRoute('front_cart_page');
    }

    public function removeFromCart(Request $request, CommandBus $commandBus)
    {
        $params = $request->request->all();
        $params['customer'] = $this->getUser();
        $removeFromCartCommand = RemoveProductFromCartCommand::fromArray($params);
        try {
            $commandBus->handle($removeFromCartCommand);
        } catch (\Exception $e) {
        }

        return $this->redirectToRoute('front_cart_page');
    }

    public function clearCart(CommandBus $commandBus)
    {
        $commandBus->handle(new ClearCartCommand($this->getUser()));

        return $this->redirectToRoute('front_cart_page');
    }
}
