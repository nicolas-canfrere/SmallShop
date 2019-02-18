<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 18/02/19
 * Time: 21:12
 */

namespace Bundles\ProductBundle\Repository;


use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    protected $products = [];

    public function oneByAlias(string $alias): ?Product
    {
        // TODO: Implement oneByAlias() method.
    }

    public function nextIdentity(): string
    {
        // TODO: Implement nextIdentity() method.
    }

    public function save(EntityInterface $entity): void
    {
        $this->products[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        if ( ! array_key_exists($id, $this->products)) {
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
