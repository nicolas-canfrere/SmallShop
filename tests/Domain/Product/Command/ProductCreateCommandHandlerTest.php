<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 19/02/19
 * Time: 01:21
 */

namespace Domain\Tests\Product\Command;


use Bundles\ProductBundle\Command\ProductCreateCommand;
use Bundles\ProductBundle\Repository\InMemoryProductRepository;
use Domain\Product\Command\ProductCreateCommandHandler;
use Domain\Product\Exception\ProductAlreadyExistsException;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;
use Domain\Product\ValueObject\ProductName;
use Domain\Stock\Signature\StockRepositoryInterface;
use Domain\Tests\Product\ProductTestCase;
use Money\Currency;
use Money\Money;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ProductCreateCommandHandlerTest extends ProductTestCase
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
        $this->expectExceptionMessage('Product named a name already exists!');

        $productA = $this->createProduct('abc', 'a name', 100, 'a-name');
        $this->productRepository->save($productA);

        $command              = new ProductCreateCommand();
        $command->setName(new ProductName('a name'));
        $command->setPrice(new Money(1000, new Currency('EUR')));
        $command->setDescription('description');

        $this->handler->handle($command);


    }

    /**
     * @test
     */
    public function productIsRegistred()
    {
        $command              = new ProductCreateCommand();
        $command->setName(new ProductName('a name'));
        $command->setPrice(new Money(1000, new Currency('EUR')));
        $command->setDescription('description');

        $this->handler->handle($command);

        $product = $this->productRepository->oneById($command->getUuid());
        $this->assertNotNull($product);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('a-name', $product->getAlias());
        $this->assertTrue($product->getName()->equals($command->getName()));
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();

        $this->handler = new ProductCreateCommandHandler(
            $this->productRepository,
            $this->createMock(StockRepositoryInterface::class),
            $this->createMock(EventDispatcherInterface::class)
        );
    }


}
