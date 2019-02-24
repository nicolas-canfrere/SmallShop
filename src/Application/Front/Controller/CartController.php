<?php

namespace Application\Front\Controller;

use Domain\Cart\Command\AddProductToCartCommand;
use Domain\Cart\Command\ClearCartCommand;
use Domain\Cart\Command\RemoveProductFromCartCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CartController.
 */
class CartController extends AbstractController
{
    public function addToCart(Request $request, CommandBus $commandBus)
    {
        $params           = $request->request->all();
        $addToCartCommand = AddProductToCartCommand::FromArray($params);
        try {
            $commandBus->handle($addToCartCommand);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $this->redirectToRoute('front_cart_page');
    }

    public function removeFromCart(Request $request, CommandBus $commandBus)
    {
        $params                = $request->request->all();
        $removeFromCartCommand = RemoveProductFromCartCommand::FromArray($params);
        try {
            $commandBus->handle($removeFromCartCommand);
        } catch (\Exception $e) {
        }

        return $this->redirectToRoute('front_cart_page');
    }

    public function clearCart(CommandBus $commandBus)
    {
        $commandBus->handle(new ClearCartCommand());

        return $this->redirectToRoute('front_cart_page');
    }
}
