<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:45
 */

namespace Domain\Product\Command;


use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Core\Urlizer;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;
use Domain\Stock\Signature\StockRepositoryInterface;
use Domain\Stock\Stock;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRepositoryInterface $stockRepository,
        EventDispatcherInterface $eventDispatcher
    ) {

        $this->productRepository = $productRepository;
        $this->stockRepository   = $stockRepository;
        $this->eventDispatcher   = $eventDispatcher;
    }

    public function handle(ProductCreateCommand $command)
    {
        $alias   = Urlizer::urlize($command->name->getName());
        $product = $this->productRepository->oneByAlias($alias);
        if ($product) {
            throw new ProductAlreadyExistsException('Product named '.$command->name->getName().' already exists!');
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

        //$stock = Stock::create($identity);
        //$this->stockRepository->save($stock);

        $command->uuid = $identity;
    }
}
