<?php

namespace Domain\Product\Command;

use Domain\Core\CommandBus\CommandHandlerInterface;
use Domain\Core\CommandBus\CommandInterface;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Urlizer;
use Domain\Product\Event\ProductUpdatedEvent;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Signature\ProductRepositoryInterface;

class ProductUpdateCommandHandler implements CommandHandlerInterface
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
     * @param CommandInterface|ProductUpdateCommandInterface $command
     *
     * @throws ProductAlreadyExistsException
     */
    public function handle(CommandInterface $command)
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

        $this->eventBus->dispatch(new ProductUpdatedEvent($original));
    }
}
