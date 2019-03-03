<?php

namespace Bundles\AddressBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Domain\Address\Address;
use Domain\Address\Signature\AddressRepositoryInterface;
use Domain\Core\Signature\EntityInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class AddressRepository.
 */
class AddressRepository implements AddressRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     *
     * @return mixed
     */
    public function getAllByCustomerId(string $id)
    {
        return $this->queryBuilder()
                    ->leftJoin('address.owner', 'owner')
                    ->andWhere('owner.id = :id')->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
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
        return $this->queryBuilder()
                    ->andWhere('address.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('address')->from(Address::class, 'address')
            ;
    }

    public function all()
    {
        return $this->queryBuilder()->getQuery()->getResult();
    }
}
