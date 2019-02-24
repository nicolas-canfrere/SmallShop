<?php

namespace Domain\Core\Signature;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface RepositoryInterface.
 */
interface RepositoryInterface
{
    public function nextIdentity(): string;

    public function save(EntityInterface $entity): void;

    public function oneById(string $id);

    public function queryBuilder(): QueryBuilder;

    public function all();
}
