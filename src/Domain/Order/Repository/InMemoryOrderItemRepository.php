<?php

namespace Domain\Order\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Order\Signature\OrderItemRepositoryInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class InMemoryOrderItemRepository.
 */
class InMemoryOrderItemRepository implements OrderItemRepositoryInterface
{
    protected $items = [];

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(EntityInterface $entity): void
    {
        $this->items[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        if (!array_key_exists($id, $this->items)) {
            return null;
        }

        return $this->items[$id];
    }

    public function queryBuilder(): QueryBuilder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all()
    {
        return $this->items;
    }
}
