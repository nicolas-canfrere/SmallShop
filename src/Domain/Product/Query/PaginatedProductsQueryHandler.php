<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 17/02/19
 * Time: 20:19
 */

namespace Domain\Product\Query;


use Domain\Core\Signature\QueryHandlerInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;

class PaginatedProductsQueryHandler implements QueryHandlerInterface
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

    public function handle(PaginatedProductsQuery $query)
    {
        $paginatedProducts = $this->paginator->paginate(
            $this->productRepository->queryBuilder()->orderBy('product.name')->getQuery(),
            $query->page,
            $query->limit
        );

        return $paginatedProducts;
    }
}
