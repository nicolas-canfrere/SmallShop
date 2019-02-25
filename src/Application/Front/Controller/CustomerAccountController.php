<?php

namespace Application\Front\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerAccountController extends AbstractController
{
    public function index(Request $request)
    {
        $customer = $this->getUser();

        return $this->render('@front/CustomerAccount/index.html.twig');
    }
}
