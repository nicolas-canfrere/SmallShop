<?php

namespace Application\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function default()
    {
        return $this->render('@admin/Home/default.html.twig');
    }
}
