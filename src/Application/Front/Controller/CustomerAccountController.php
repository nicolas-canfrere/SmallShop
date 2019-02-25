<?php

namespace Application\Front\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerAccountController extends AbstractController
{
    public function index(Request $request)
    {
        return $this->render('@front/CustomerAccount/index.html.twig');
    }
}