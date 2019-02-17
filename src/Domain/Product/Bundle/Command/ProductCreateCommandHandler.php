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

class ProductCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {

        $this->productRepository = $productRepository;
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

        $command->uuid = $identity;
    }
}
