<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/02/19
 * Time: 11:33
 */

namespace Domain\Product\Bundle\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Domain\Product\Product;
use Domain\Product\Signature\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

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
        return $this->entityManager->createQueryBuilder()->select('product')->from(Product::class, 'product');
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
