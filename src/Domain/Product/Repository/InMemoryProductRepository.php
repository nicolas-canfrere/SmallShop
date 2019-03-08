<?php

namespace Domain\Product\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product[]
     */
    protected $products = [];

    public function oneByAlias(string $alias): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getAlias() === $alias) {
                return $product;
            }
        }

        return null;
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(EntityInterface $entity): void
    {
        $this->products[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        if (!array_key_exists($id, $this->products)) {
            return null;
        }

        return $this->products[$id];
    }

    public function queryBuilder(): QueryBuilder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
}
