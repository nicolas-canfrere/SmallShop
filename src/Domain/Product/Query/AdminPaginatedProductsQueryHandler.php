<?php

namespace Domain\Product\Query;

use Domain\Core\QueryBus\QueryHandlerInterface;
use Domain\Core\QueryBus\QueryInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class AdminPaginatedProductsQueryHandler.
 */
class AdminPaginatedProductsQueryHandler implements QueryHandlerInterface
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
     * @param QueryInterface|AdminPaginatedProductsQuery $query
     *
     * @return mixed
     */
    public function handle(QueryInterface $query)
    {
        $paginatedProducts = $this->paginator->paginate(
            $this->productRepository->queryBuilder()->orderBy('product.name')->getQuery(),
            $query->page,
            $query->limit
        );

        return $paginatedProducts;
    }
}
