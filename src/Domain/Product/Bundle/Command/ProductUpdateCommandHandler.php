<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 19:37
 */

namespace Domain\Product\Bundle\Command;


use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Core\Urlizer;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Signature\ProductRepositoryInterface;

class ProductUpdateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function handle(ProductUpdateCommand $command)
    {
        $original = $command->original;
        $alias    = Urlizer::urlize($command->name);
        if ($original->getName() != $command->name) {

            $test = $this->productRepository->oneByAlias($alias);

            if ($test && $test->getId() !== $original->getId()) {

                throw new ProductAlreadyExistsException('Product named '.$command->name.' already exists!');
            }
        }

        $original->update(
            $command->name,
            $command->price,
            $alias,
            $command->description,
            $command->onSale
        );
        $this->productRepository->save($original);
    }
}
