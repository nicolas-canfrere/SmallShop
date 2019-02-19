<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 19:37
 */

namespace Domain\Product\Command;


use Domain\Core\Signature\CommandHandlerInterface;
use Domain\Core\Urlizer;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Signature\ProductRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ProductUpdateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {

        $this->productRepository = $productRepository;
        $this->eventDispatcher   = $eventDispatcher;
    }

    public function handle(ProductUpdateCommandInterface $command)
    {
        $original = $command->getOriginal();
        $alias    = Urlizer::urlize($command->getName()->getName());
        if ( ! $original->getName()->equals($command->getName())) {

            $test = $this->productRepository->oneByAlias($alias);

            if ($test && $test->getId() !== $original->getId()) {

                throw new ProductAlreadyExistsException(
                    'Product named '.$command->getName()->getName().' already exists!'
                );
            }
        }

        $original->update(
            $command->getName(),
            $command->getPrice(),
            $alias,
            $command->getDescription(),
            $command->isOnSale()
        );
        $this->productRepository->save($original);

        // TODO dispatch Event
    }
}
