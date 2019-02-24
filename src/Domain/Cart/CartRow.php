<?php

namespace Domain\Cart;

use Domain\Cart\Signature\CartRowInterface;
use Domain\Product\Signature\ProductInterface;
use Domain\Product\ValueObject\ProductName;
use Money\Currency;
use Money\Money;

class CartRow implements CartRowInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var ProductInterface
     */
    protected $product;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var ProductName
     */
    protected $productName;

    /**
     * @var Money
     */
    protected $productPrice;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var Money
     */
    protected $totalPrice;

    /**
     * {@inheritdoc}
     */
    public static function create(string $id, ProductInterface $product, int $count = 1): CartRowInterface
    {
        $row = new static();
        $row->id = $id;
        $row->product = $product;
        $row->productId = $product->getId();
        $row->productName = $product->getName();
        $row->productPrice = $product->getPrice();
        $row->count = $count;
        $row->calculTotalPrice();

        return $row;
    }

    protected function calculTotalPrice(): void
    {
        $this->totalPrice = $this->productPrice->multiply($this->count);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $array): CartRowInterface
    {
        $row = new static();
        $row->id = $array['id'];
        $row->productId = $array['productId'];
        $row->productName = new ProductName($array['productName']);
        $row->productPrice = new Money($array['price'], new Currency($array['currency']));
        $row->count = $array['count'];
        $row->calculTotalPrice();

        return $row;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'productId' => $this->productId,
            'productName' => $this->productName->getName(),
            'price' => $this->productPrice->getAmount(),
            'currency' => $this->productPrice->getCurrency()->getCode(),
            'count' => $this->count,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function add(int $numberOfItem): void
    {
        $this->count += $numberOfItem;
        $this->calculTotalPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(int $numberOfItem): void
    {
        $this->count -= $numberOfItem;
        if ($this->count < 0) {
            $this->count = 0;
        }
        $this->calculTotalPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductName(): ProductName
    {
        return $this->productName;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductPrice(): Money
    {
        return $this->productPrice;
    }
}
