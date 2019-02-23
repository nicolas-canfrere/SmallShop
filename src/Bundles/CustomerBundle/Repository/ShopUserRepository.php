<?php

namespace Bundles\CustomerBundle\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Ramsey\Uuid\Uuid;

class ShopUserRepository implements CustomerRepositoryInterface
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

    public function save(EntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
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
}