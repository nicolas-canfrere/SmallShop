<?php

namespace Application\Front\Controller;

use Domain\Product\Query\FrontPaginatedProductsQuery;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function default(Request $request, CommandBus $queryBus)
    {
        $query             = new FrontPaginatedProductsQuery($request->query->getInt('page', 1), 8);
        $paginatedProducts = $queryBus->handle($query);

        return $this->render('@front/Home/default.html.twig', ['paginatedProducts' => $paginatedProducts]);
    }
}
