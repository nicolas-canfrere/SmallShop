<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 13:45
 */

namespace Domain\Product\Command;


use Bundles\ProductBundle\Command\ProductCreateCommand;
use Domain\Core\Event\EventBusInterface;
use Domain\Core\Signature\CommandHandlerInterface;
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
    )
    {

        $this->productRepository = $productRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param ProductCreateCommand $command
     * @throws ProductAlreadyExistsException
     */
    public function handle(ProductCreateCommand $command)
    {
        if (!$command instanceof ProductCreateCommandInterface) {
            throw new \InvalidArgumentException('command must implement ' . ProductCreateCommandInterface::class);
        }

        $alias = Urlizer::urlize($command->getName()->getName());
        $product = $this->productRepository->oneByAlias($alias);
        if ($product) {
            throw new ProductAlreadyExistsException('Product named ' . $command->getName()->getName() . ' already exists!');
        }

        $identity = $this->productRepository->nextIdentity();

        $product = Product::create(
            $identity,
            $command->getName(),
            $command->getPrice(),
            $alias,
            $command->getDescription()
        );
        $this->productRepository->save($product);

        $command->setUuid($identity);

        $this->eventBus->dispatch(new ProductCreatedEvent($product));
    }
}
