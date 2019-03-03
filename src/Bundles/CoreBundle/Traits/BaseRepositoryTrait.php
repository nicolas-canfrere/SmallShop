<?php

namespace Bundles\CoreBundle\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Core\Signature\EntityInterface;
use Ramsey\Uuid\Uuid;

/**
 * Trait BaseRepositoryTrait
 * @package Bundles\CoreBundle\Traits
 */
trait BaseRepositoryTrait
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
}
