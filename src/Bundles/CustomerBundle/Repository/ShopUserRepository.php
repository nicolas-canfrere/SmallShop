<?php

namespace Bundles\CustomerBundle\Repository;

use Bundles\CustomerBundle\Model\ShopUser;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Core\Urlizer;
use Domain\Customer\Signature\CustomerInterface;
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
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('shop_user')->from(ShopUser::class, 'shop_user');
    }

    public function all()
    {
        return $this->queryBuilder()->getQuery()->getResult();
    }

    public function oneByUsername(string $username): ?CustomerInterface
    {
        $canonical = Urlizer::urlize($username);

        $qb = $this->queryBuilder();
        $qb->andWhere('shop_user.canonicalUsername = :canonical')->setParameter('canonical', $canonical);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function oneByEmail(string $email): ?CustomerInterface
    {
        $canonical = Urlizer::urlize($email);

        $qb = $this->queryBuilder();
        $qb->andWhere('shop_user.canonicalEmail = :canonical')->setParameter('canonical', $canonical);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function oneByUsernameOrEmail(string $username): ?CustomerInterface
    {
        $canonical = Urlizer::urlize($username);
        $qb = $this->queryBuilder();
        $qb->andWhere('shop_user.canonicalEmail = :canonical');
        $qb->orWhere('shop_user.canonicalUsername = :canonical');
        $qb->setParameter('canonical', $canonical);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
