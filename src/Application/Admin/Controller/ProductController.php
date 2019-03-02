<?php

namespace Application\Admin\Controller;

use Application\Admin\Form\ProductCreateForm;
use Application\Admin\Form\ProductUpdateForm;
use Bundles\ProductBundle\Command\ProductCreateCommand;
use Bundles\ProductBundle\Command\ProductUpdateCommand;
use Domain\Core\CommandBus\CommandBus as DomainCommandBus;
use Domain\Core\QueryBus\QueryBus;
use Domain\Product\Query\AdminPaginatedProductsQuery;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    public function list(Request $request, QueryBus $queryBus)
    {
        $query = new AdminPaginatedProductsQuery($request->query->getInt('page', 1));
        $paginatedProducts = $queryBus->handle($query);

        return $this->render('@admin/Product/list.html.twig', ['paginatedProducts' => $paginatedProducts]);
    }



    public function add(Request $request, DomainCommandBus $commandBus)
    {
        $createProductCommand = new ProductCreateCommand();
        $form = $this->createForm(ProductCreateForm::class, $createProductCommand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->handle($createProductCommand);
                $this->addFlash('success', $createProductCommand->getName().' created!');

                return $this->redirectToRoute('admin_products_list');
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('@admin/Product/add.html.twig', ['form' => $form->createView()]);
    }

    public function edit(
        string $uuid,
        Request $request,
        ProductRepositoryInterface $productRepository,
        DomainCommandBus $commandBus
    ) {
        $product = $productRepository->oneById($uuid);
        if (!$product) {
            $this->addFlash('danger', 'product not found!');

            return $this->redirectToRoute('admin_products_list');
        }
        $updateCommand = ProductUpdateCommand::fromProduct($product);
        $form = $this->createForm(ProductUpdateForm::class, $updateCommand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->handle($updateCommand);
                $this->addFlash('success', $updateCommand->original->getName().' updated!');

                return $this->redirectToRoute('admin_products_list');
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('@admin/Product/edit.html.twig', ['form' => $form->createView()]);
    }
}
