<?php

namespace Domain\Address\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Address\Signature\AddressInterface;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Core\Signature\EntityInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class InMemoryAddressRepository.
 */
class InMemoryAddressRepository implements AddressRepositoryInterface
{
    /**
     * @var AddressInterface[];
     */
    protected $addresses = [];

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(EntityInterface $entity): void
    {
        $this->addresses[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        // TODO: Implement oneById() method.
    }

    public function queryBuilder(): QueryBuilder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getAllByCustomerId(string $id)
    {
        return array_filter($this->addresses, function (AddressInterface $address) use ($id) {
            return $address->isOwnedBy($id);
        });
    }
}
