<?php

namespace Domain\Product\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Urlizer;
use Domain\Product\Event\ProductCreatedEvent;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;

class ProductCreateCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var EventBusInterface
     */
    private $eventBus;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        EventBusInterface $eventBus
    ) {
        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param ProductCreateCommandInterface|CommandInterface $command
     *
     * @throws ProductAlreadyExistsException
     */
    public function handle(CommandInterface $command)
    {
        $alias = Urlizer::urlize($command->getName()->getName());
        $product = $this->productRepository->oneByAlias($alias);
        if ($product) {
            throw new ProductAlreadyExistsException('Product named '.$command->getName()->getName().' already exists!');
        }

        $identity = $this->productRepository->nextIdentity();

        $product = Product::create(
            $identity,
            $command->getName(),
            $command->getPrice(),
            $alias,
            $command->getDescription()
        );
        $product->setTags($command->getTags());
        $this->productRepository->save($product);

        $command->setUuid($identity);

        $this->eventBus->dispatch(new ProductCreatedEvent($product));
    }
}
