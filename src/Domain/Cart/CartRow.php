<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 16/02/19
 * Time: 11:57
 */

namespace Domain\Cart;


use Domain\Cart\Signature\CartRowInterface;
use Domain\Product\Signature\ProductInterface;
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
     * @var string
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

    public static function create(string $id, ProductInterface $product, int $count = 1)
    {
        $row               = new static();
        $row->id           = $id;
        $row->product      = $product;
        $row->productId    = $product->getId();
        $row->productName  = $product->getName();
        $row->productPrice = $product->getPrice();
        $row->count        = $count;
        $row->calculTotalPrice();

        return $row;

    }

    protected function calculTotalPrice()
    {
        $this->totalPrice = $this->productPrice->multiply($this->count);
    }

    public static function fromArray(array $array): CartRowInterface
    {
        $row               = new static();
        $row->id           = $array['id'];
        $row->productId    = $array['productId'];
        $row->productName  = $array['productName'];
        $row->productPrice = new Money($array['price'], new Currency($array['currency']));
        $row->count        = $array['count'];
        $row->calculTotalPrice();

        return $row;
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'productId'   => $this->productId,
            'productName' => $this->productName,
            'price'       => $this->productPrice->getAmount(),
            'currency'    => $this->productPrice->getCurrency()->getCode(),
            'count'       => $this->count,
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function add(int $numberOfItem)
    {
        $this->count += $numberOfItem;
        $this->calculTotalPrice();
    }

    public function remove(int $numberOfItem)
    {
        $this->count -= $numberOfItem;
        if ($this->count < 0) {
            $this->count = 0;
        }
        $this->calculTotalPrice();
    }

    /**
     * @return Money
     */
    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @return Money
     */
    public function getProductPrice(): Money
    {
        return $this->productPrice;
    }


}
