<?php

namespace Application\Front\Controller;

use Bundles\CustomerBundle\Command\CustomerUpdateInfosCommand;
use Bundles\CustomerBundle\Form\UpdateInfosForm;
use Domain\Core\CommandBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerAccountController extends AbstractController
{
    public function index(Request $request, CommandBus $commandBus)
    {
        $customer = $this->getUser();

        dump($customer);

        $command = new CustomerUpdateInfosCommand($customer);
        $form = $this->createForm(UpdateInfosForm::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->handle($command);
            } catch (\Exception $e) {
            }
        }

        return $this->render('@front/CustomerAccount/index.html.twig', ['form' => $form->createView()]);
    }
}
