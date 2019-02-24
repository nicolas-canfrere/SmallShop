<?php

namespace Domain\Product\Event;

use Domain\Core\Event\Event;
use Domain\Product\Signature\ProductInterface;

final class ProductUpdatedEvent extends Event
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * ProductCreatedEvent constructor.
     *
     * @param $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }
}
