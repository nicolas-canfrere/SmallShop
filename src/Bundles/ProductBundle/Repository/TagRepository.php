<?php

namespace Bundles\ProductBundle\Repository;

use Bundles\CoreBundle\Traits\BaseRepositoryTrait;
use Doctrine\ORM\QueryBuilder;
use Domain\Product\Signature\TagRepositoryInterface;
use Domain\Product\Tag;

/**
 * Class TagRepository
 */
class TagRepository implements TagRepositoryInterface
{
    use BaseRepositoryTrait;

    public function oneById(string $id)
    {
        return $this->queryBuilder()
            ->andWhere('tag.id = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('tag')
            ->from(Tag::class, 'tag');
    }

    public function all()
    {
        return $this->queryBuilder()->getQuery()->getResult();
    }

    public function getTags(array $names): array
    {
        return $this->queryBuilder()
            ->andWhere('tag.name IN(:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();
    }
}
