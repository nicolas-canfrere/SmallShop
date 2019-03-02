<?php

namespace Application\Front\Controller;

use Domain\Core\QueryBus\QueryBus;
use Domain\Product\Query\FrontPaginatedProductsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function default(Request $request, QueryBus $queryBus)
    {
        $query = new FrontPaginatedProductsQuery($request->query->getInt('page', 1), 8);
        $paginatedProducts = $queryBus->handle($query);

        return $this->render('@front/Home/default.html.twig', ['paginatedProducts' => $paginatedProducts]);
    }
}
