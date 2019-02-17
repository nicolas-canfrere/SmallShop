<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:45
 */

namespace Domain\Product\Bundle\Command;


use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Core\Urlizer;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;
use Domain\Stock\Signature\StockRepositoryInterface;
use Domain\Stock\Stock;

class ProductCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var StockRepositoryInterface
     */
    private $stockRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRepositoryInterface $stockRepository
    )
    {

        $this->productRepository = $productRepository;
        $this->stockRepository   = $stockRepository;
    }

    public function handle(ProductCreateCommand $command)
    {
        $alias   = Urlizer::urlize($command->name);
        $product = $this->productRepository->oneByAlias($alias);
        if ($product) {
            throw new ProductAlreadyExistsException('Product named '.$command->name.' already exists!');
        }

        $identity = $this->productRepository->nextIdentity();

        $product = Product::create(
            $identity,
            $command->name,
            $command->price,
            $alias,
            $command->description
        );
        $this->productRepository->save($product);

        $stock = Stock::create($identity);
        $this->stockRepository->save($stock);

        $command->uuid = $identity;
    }
}
