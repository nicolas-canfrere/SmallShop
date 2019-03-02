<?php

namespace Application\Admin\Controller;

use Domain\Core\QueryBus\QueryBus;
use Domain\Customer\Query\AllCustomersQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    public function list(Request $request, QueryBus $queryBus)
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $customers = $queryBus->handle(new AllCustomersQuery($page, $limit));

        return $this->render('@admin/Customer/list.html.twig', ['customers' => $customers]);
    }
}
