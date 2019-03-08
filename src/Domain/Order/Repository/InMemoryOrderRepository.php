<?php

namespace Domain\Order\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Order\Signature\OrderRepositoryInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class InMemoryOrderRepository.
 */
class InMemoryOrderRepository implements OrderRepositoryInterface
{
    protected $orders = [];

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(EntityInterface $entity): void
    {
        $this->orders[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        if (!array_key_exists($id, $this->orders)) {
            return null;
        }

        return $this->orders[$id];
    }

    public function queryBuilder(): QueryBuilder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all()
    {
        return $this->orders;
    }
}
