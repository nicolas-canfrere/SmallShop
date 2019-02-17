<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 10:58
 */

namespace Application\Admin\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function default()
    {
        return $this->render('@admin/Home/default.html.twig');
    }
}
