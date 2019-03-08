<?php

namespace Tests\Domain\Product\Command;

use Bundles\ProductBundle\Command\ProductUpdateCommand;
use Domain\Core\Event\EventBus;
use Domain\Core\Event\EventListenerProvider;
use Domain\Product\Command\ProductCreateCommandHandler;
use Domain\Product\Command\ProductUpdateCommandHandler;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Repository\InMemoryProductRepository;
use Domain\Product\Signature\ProductRepositoryInterface;
use Domain\Product\ValueObject\ProductName;
use Tests\Domain\Product\ProductTestCase;

class ProductUpdateCommandHandlerTest extends ProductTestCase
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var ProductCreateCommandHandler
     */
    protected $handler;

    /**
     * @test
     */
    public function mustThrowExceptionIfAProductAlreadyExistsWithSameName()
    {
        $this->expectException(ProductAlreadyExistsException::class);
        $this->expectExceptionMessage('Product named an another name already exists!');

        $productA = $this->createProduct('abc', 'a name', 100, 'a-name');
        $this->productRepository->save($productA);

        $productB = $this->createProduct('def', 'an another name', 100, 'an-another-name');
        $this->productRepository->save($productB);

        $command = ProductUpdateCommand::fromProduct($productA);
        $command->setName($productB->getName());

        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function productIsUpdate()
    {
        $productA = $this->createProduct('abc', 'a name', 100, 'a-name');
        $this->productRepository->save($productA);

        $command = ProductUpdateCommand::fromProduct($productA);
        $newName = new ProductName('changed name');
        $command->setName($newName);

        $this->handler->handle($command);

        $updated = $this->productRepository->oneById('abc');
        $this->assertTrue($updated->getName()->equals($newName));
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
        $eventBus = new EventBus(new EventListenerProvider());
        $this->handler = new ProductUpdateCommandHandler(
            $this->productRepository,
            $eventBus
        );
    }
}
