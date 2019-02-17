<?php

namespace Domain\Core\Signature;


use Doctrine\ORM\QueryBuilder;

/**
 * Interface RepositoryInterface
 * @package Domain\Core\Signature
 */
interface RepositoryInterface
{
    public function nextIdentity(): string;

    public function save($entity): void;

    public function oneById(string $id);

    public function queryBuilder(): QueryBuilder;

    public function all();
}
