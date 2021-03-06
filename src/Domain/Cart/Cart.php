<?php

namespace Domain\Cart;

use Domain\Cart\Exception\CartException;
use Domain\Cart\Signature\CartInterface;
use Domain\Cart\Signature\CartRowInterface;
use Domain\Product\Signature\ProductInterface;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Traversable;

/**
 * Class Cart.
 */
class Cart implements \Countable, \IteratorAggregate, CartInterface
{
    const ALL_PRODUCTS_IN_ROW = 'all';

    /**
     * @var CartRow[]
     */
    protected $rows = [];

    /**
     * @var string
     */
    protected $defaultCurrency;

    /**
     * Cart constructor.
     *
     * @param string $defaultCurrency
     */
    public function __construct(string $defaultCurrency = 'EUR')
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(ProductInterface $product, int $count = 1): void
    {
        if ($count < 1) {
            throw new CartException('Can not add negative number of items');
        }
        if (!array_key_exists($product->getId(), $this->rows)) {
            $this->rows[$product->getId()] = CartRow::create(Uuid::uuid4()->toString(), $product, $count);
        } else {
            $row = $this->rows[$product->getId()];
            $row->add($count);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(ProductInterface $product, int $count = 1): void
    {
        if (!array_key_exists($product->getId(), $this->rows)) {
            throw new CartException('Product not in cart');
        }
        if ($count < 1) {
            throw new CartException('Can not remove negative number of items');
        }
        $row = $this->rows[$product->getId()];
        $row->remove($count);

        if ($row->getCount() < 1) {
            $this->deleteRow($product->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow(string $id): void
    {
        if (array_key_exists($id, $this->rows)) {
            unset($this->rows[$id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): void
    {
        $this->rows = [];
    }

    /**
     * @return \ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->rows);
    }

    /**
     * {@inheritdoc}
     */
    public function totalPrice(): Money
    {
        $accumulateur = new Money(0, new Currency($this->defaultCurrency));
        if ($this->count()) {
            return array_reduce(
                $this->rows,
                function (Money $accumulateur, CartRowInterface $item) {
                    $current = $item->getTotalPrice();
                    $accumulateur = $accumulateur->add($current);

                    return $accumulateur;
                },
                $accumulateur
            );
        }

        return $accumulateur;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        $total = 0;
        foreach ($this as $row) {
            $total += $row->getCount();
        }

        return $total;
    }

    /**
     * {@inheritdoc}
     */
    public function itemIsRegistred(string $id): bool
    {
        return array_key_exists($id, $this->rows) && !empty($this->rows[$id]);
    }
}
