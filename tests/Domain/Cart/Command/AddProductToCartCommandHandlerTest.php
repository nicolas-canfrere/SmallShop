<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/02/19
 * Time: 20:59
 */

namespace Domain\Tests\Cart\Command;


use Bundles\ProductBundle\Repository\InMemoryProductRepository;
use Domain\Cart\Cart;
use Domain\Cart\Command\AddProductToCartCommand;
use Domain\Cart\Command\AddProductToCartCommandHandler;
use Domain\Cart\Signature\CartInterface;
use Domain\Product\Exception\ProductNotFoundException;
use Domain\Product\Product;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\Signature\ProductRepositoryInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AddProductToCartCommandHandlerTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var ProductInterface
     */
    protected $product;
    /**
     * @var CartInterface
     */
    protected $cart;
    /**
     * @var AddProductToCartCommandHandler
     */
    protected $handler;

    /**
     * @test
     */
    public function canAddProductToCart()
    {
        $this->assertEquals(0, count($this->cart));

        $command            = new AddProductToCartCommand();
        $command->quantity  = 1;
        $command->productId = 'abc';

        $this->handler->handle($command);

        $this->assertEquals(1, count($this->cart));
        $this->assertTrue($this->cart->itemIsRegistred('abc'));
    }

    /**
     * @test
     */
    public function mustThrowExceptionWhenProductNotExist()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('product not found');

        $command            = new AddProductToCartCommand();
        $command->productId = 'throw-exception!';
        $this->handler->handle($command);
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->product           = Product::create(
            'abc',
            'a product',
            new Money(1000, new Currency('EUR')),
            'alias',
            'description'
        );
        $this->productRepository->save($this->product);
        $this->cart = new Cart();

        $this->handler = new AddProductToCartCommandHandler(
            $this->createMock(EventDispatcherInterface::class),
            $this->productRepository,
            $this->cart
        );
    }
}
