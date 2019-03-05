<?php

namespace Bundles\ProductBundle\Repository;

use Bundles\CoreBundle\Traits\BaseRepositoryTrait;
use Doctrine\ORM\QueryBuilder;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    use BaseRepositoryTrait;

    public function oneById(string $id)
    {
        return $this->queryBuilder()
                    ->andWhere('product.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('product')
            ->from(Product::class, 'product')
            ->leftJoin('product.tags', 'tags')->addSelect('tags')
            ;
    }

    public function all()
    {
        return $this->queryBuilder()->getQuery()->getResult();
    }

    public function oneByAlias(string $alias): ?Product
    {
        return $this->queryBuilder()
                    ->andWhere('product.alias = :alias')
                    ->setParameter('alias', $alias)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
