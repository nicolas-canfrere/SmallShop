<?php

namespace Domain\Product\Query;

use Domain\Core\Signature\QueryHandlerInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;

class FrontPaginatedProductsQueryHandler implements QueryHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ProductRepositoryInterface $productRepository, PaginatorInterface $paginator)
    {
        $this->productRepository = $productRepository;
        $this->paginator         = $paginator;
    }

    public function handle(FrontPaginatedProductsQuery $query)
    {
        $paginatedProducts = $this->paginator->paginate(
            $this->productRepository
                ->queryBuilder()
                ->andWhere('product.onSale = :onSale')
                ->setParameter('onSale', true)
                ->orderBy('product.name')->getQuery(),
            $query->page,
            $query->limit
        );

        return $paginatedProducts;
    }
}
