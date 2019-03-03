<?php

namespace Application\Front\Controller;

use Bundles\AddressBundle\Command\AddressCreateCommand;
use Bundles\AddressBundle\Form\ShopUserAddAddressForm;
use Bundles\CustomerBundle\Command\CustomerUpdateInfosCommand;
use Bundles\CustomerBundle\Form\UpdateInfosForm;
use Domain\Address\Query\CustomerAddressesQuery;
use Domain\Core\CommandBus\CommandBus;
use Domain\Core\QueryBus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerAccountController extends AbstractController
{
    public function index(Request $request, CommandBus $commandBus)
    {
        $customer = $this->getUser();

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

    public function addresses(QueryBus $queryBus)
    {
        $customer = $this->getUser();

        $query = new CustomerAddressesQuery($customer);

        try {
            $addressBook = $queryBus->handle($query);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $this->render('@front/CustomerAccount/addresses.html.twig', ['addressBook' => $addressBook]);
    }

    public function addAddress(Request $request, CommandBus $commandBus)
    {
        $owner = $this->getUser();
        $newAddress = new AddressCreateCommand($owner);
        $form = $this->createForm(ShopUserAddAddressForm::class, $newAddress);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('@front/CustomerAccount/add_ddresses.html.twig', ['form' => $form->createView()]);
    }
}
