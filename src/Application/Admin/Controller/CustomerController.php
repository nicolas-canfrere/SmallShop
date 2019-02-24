<?php

namespace Application\Admin\Controller;

use Domain\Customer\Query\AllCustomersQuery;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    public function list(Request $request, CommandBus $queryBus)
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $customers = $queryBus->handle(new AllCustomersQuery($page, $limit));

        return $this->render('@admin/Customer/list.html.twig', ['customers' => $customers]);
    }
}
