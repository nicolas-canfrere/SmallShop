<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:27
 */

namespace Application\Admin\Controller;


use Application\Admin\Form\ProductCreateForm;
use Application\Admin\Form\ProductUpdateForm;
use Domain\Product\Bundle\Command\ProductCreateCommand;
use Domain\Product\Bundle\Command\ProductUpdateCommand;
use Domain\Product\Bundle\Query\PaginatedProductsQuery;
use Domain\Product\Signature\ProductRepositoryInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    public function list(Request $request, CommandBus $queryBus)
    {
        $query = new PaginatedProductsQuery($request->query->getInt('page', 1));
        $paginatedProducts = $queryBus->handle($query);

        return $this->render('@admin/Product/list.html.twig', ['paginatedProducts' => $paginatedProducts]);
    }

    public function add(Request $request, CommandBus $commandBus)
    {
        $createProductCommand = new ProductCreateCommand();
        $form                 = $this->createForm(ProductCreateForm::class, $createProductCommand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->handle($createProductCommand);
                $this->addFlash('success', $createProductCommand->name.' created!');

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
        CommandBus $commandBus
    ) {
        $product = $productRepository->oneById($uuid);
        if ( ! $product) {
            $this->addFlash('danger', 'product not found!');

            return $this->redirectToRoute('admin_products_list');
        }
        $updateCommand = ProductUpdateCommand::fromProduct($product);
        $form          = $this->createForm(ProductUpdateForm::class, $updateCommand);
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
