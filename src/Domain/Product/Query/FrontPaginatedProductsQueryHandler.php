<?php

namespace Domain\Product\Query;

use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\QueryBus\QueryInterface;
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
        $this->paginator = $paginator;
    }

    /**
     * @param QueryInterface|FrontPaginatedProductsQuery $query
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface|mixed
     */
    public function handle(QueryInterface $query)
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
