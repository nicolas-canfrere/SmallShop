<?php

namespace Bundles\CustomerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Core\Signature\EntityInterface;
use Domain\Core\Urlizer;
use Domain\Customer\Signature\CustomerInterface;
use Domain\Customer\Signature\CustomerRepositoryInterface;
use Domain\Customer\ValueObject\Email;
use Ramsey\Uuid\Uuid;

class InMemoryCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var CustomerInterface[]
     */
    protected $customers = [];

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save(EntityInterface $entity): void
    {
        $this->customers[$entity->getId()] = $entity;
    }

    public function oneById(string $id)
    {
        if (!array_key_exists($id, $this->customers)) {
            return null;
        }

        return $this->customers[$id];
    }

    public function queryBuilder(): QueryBuilder
    {
        // TODO: Implement queryBuilder() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function oneByUsername(string $username): ?CustomerInterface
    {
        $canonical = Urlizer::urlize($username);

        foreach ($this->customers as $customer) {
            if ($customer->getCanonicalUsername() === $canonical) {
                return $customer;
            }
        }

        return null;
    }

    public function oneByEmail(Email $email): ?CustomerInterface
    {
        $canonical = Urlizer::urlize($email->getEmail());

        foreach ($this->customers as $customer) {
            if ($customer->getCanonicalEmail() === $canonical) {
                return $customer;
            }
        }

        return null;
    }

    public function oneByUsernameOrEmail(string $username): ?CustomerInterface
    {
        // TODO: Implement oneByUsernameOrEmail() method.
    }
}
